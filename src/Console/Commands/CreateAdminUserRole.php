<?php
namespace WFN\Admin\Console\Commands;

use Illuminate\Console\Command;
use WFN\Admin\Model\User\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use WFN\Admin\Model\Source\AdminResources;
use WFN\Admin\Model\User;

class CreateAdminUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create_user_role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $data = [
                'title' => $this->ask('Admin user role title'),
            ];
            $resources = [];
            foreach(AdminResources::getInstance()->getOptions() as $value => $label) {
                if($this->confirm('Is resource available "' . $label . '"', true)) {
                    $resources[] = $value;
                }
            }

            Validator::make($data, [
                'title' => ['required', 'string', 'max:255'],
            ])->validate();
            $data['resources'] = $resources;

            $role = Role::create($data);

            $this->info('Admin user role has been created successfully!');
            if($this->confirm('Are you want to assign role to users?', true)) {
                foreach(User::all() as $user) {
                    if($this->confirm('Assign role to ' . $user->name, true)) {
                        $user->update(['role_id' => $role->id]);
                    }
                }
            }
        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
