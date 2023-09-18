# Deploy to production

After deploy at the first time, if you receive 403 forbidden error, you should follow this guide to update User model https://filamentphp.com/docs/3.x/panels/installation#deploying-to-production

# Edit login route (if need)

By default the login route is 'filament.admin.auth.login'

If you want to change id & path of filamment, you need to edit route in to file

app/Exceptions/Handler.php
Http/Middleware/Authenticate.php

For example, if you want to change route from 'admin' to 'app', you need to update route to 'filament.app.auth.login'

# Add super admin user

Because vika-fnb has relationship: User belong to a Store, so you may receive crash code when trying to create fillament user. To prevent that, you need to do like below:

- Access tinker
- Create Store
- Create User with store_id = store.id
- Create super admin account by run command: php artisan shield:super-admin --user=[user.id]

# Hard code to vendors

## For translation

- vendor\filament\tables\resources\lang\vi\table.php

    'heading' => 'Bộ lọc',
        'column_toggle' => [
            'heading' => 'Cột',
        ],

- vendor\bezhansalleh\filament-shield\resources\lang\vi\filament-shield.php

    'nav.group' => 'Phân quyền'

## For multi-tenancy

- vendor\spatie\laravel-permission\src\Models\Role.php

    use App\Models\Team;

    ...

    public function team() : BelongsTo {
        return $this->belongsTo(Team::class);
    }h