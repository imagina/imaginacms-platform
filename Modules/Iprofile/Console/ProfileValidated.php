<?php

namespace Modules\Iprofile\Console;

use Illuminate\Console\Command;
use Modules\Iprofile\Emails\UpdateProfile;
use Modules\Iprofile\Repositories\UserRepository;
use Modules\Iprofile\Transformers\UserProfileTransformer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Facades\Mail;

class ProfileValidated extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'profile:validate';
    private $mail;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate profile information and send notification to the mail if it is not complete';

    public $user;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $user
     * @param Mailer $mail
     */
    public function __construct(UserRepository $user, Mail $mail)
    {
        parent::__construct();
        $this->user = $user;
        $this->mail = $mail;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $users =$this->user->getItemsBy((object)['take' => false, 'filter' => ['field' => ['name' => 'validate', 'value' => true]], 'include' => []]);
            $cont = 0;

            foreach ($users as $user) {
                if (!isset($user->notification)) {
                    $remove = config()->get('asgard.iprofile.config.file_remove');
                    $cont++;
                    $dataUpdate = $remove;
                    $subject = trans("iprofile::profile.messages.Update User profile");
                    $view = "iprofile::emails.update_profile";
                    $dataUpdate = array_merge($dataUpdate,['notification'=>true,'validate'=>false]);
                    $this->mail->to($user->email ?? env('MAIL_FROM_ADDRESS'))->send(new UpdateProfile($user, $subject, $view));
                    \Log::info('user ' . $user->id . ' notified');
                    $this->info('user ' . $user->id . ' notifies');
                    $this->user->update($user,$dataUpdate);
                }
            }
            $this->info($cont . ' users notified');
        }catch (\Exception $e){
            \Log::error($e->getMessage());
            $this->info($e->getMessage());
        }


    }

    /**
     * Get the console command arguments.
     *
     * @return array
     *
     * protected function getArguments()
     * {
     * return [
     * ['example', InputArgument::REQUIRED, 'An example argument.'],
     * ];
     * }
     */
    /**
     * Get the console command options.
     *
     * @return array
     *
     * protected function getOptions()
     * {
     * return [
     * ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
     * ];
     * }*/
}
