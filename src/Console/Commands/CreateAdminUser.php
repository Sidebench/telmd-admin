<?php
namespace WFN\Admin\Console\Commands;

use Illuminate\Console\Command;
use WFN\Admin\Model\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

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
                'name'     => $this->ask('Admin user name'),
                'email'    => $this->ask('Admin user email'),
                'password' => $this->secret('Admin user password'),
                'role_id'  => $this->secret('Admin user role ID'),
            ];
            Validator::make($data, [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:admin_user'],
                'password' => ['required', 'string', 'min:8'],
            ])->validate();

            $data['password'] = Hash::make($data['password']);
            User::create($data);

            $this->info('Admin user has been created successfully!');
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
