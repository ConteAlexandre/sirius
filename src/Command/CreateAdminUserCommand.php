<?php

namespace App\Command;

use App\Manager\AdminUserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateAdminUserCommand
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'create:admin:user';

    /**
     * @var AdminUserManager
     */
    protected $adminUserManager;

    /**
     * CreateAdminUserCommand constructor.
     *
     * @param AdminUserManager $adminUserManager
     * @param string|null      $name
     */
    public function __construct(AdminUserManager $adminUserManager, string $name = null)
    {
        $this->adminUserManager = $adminUserManager;
        parent::__construct($name);
    }

    /**
     * Configure arguments
     */
    protected function configure()
    {
        $this
            ->setDescription('Création d\'un utilisateur admin')
            ->setHelp('Tous les champs qui suivent sont obligatoires...')
            ->addArgument('username', InputArgument::REQUIRED, 'Le pseudo de l\'admin')
            ->addArgument('email', InputArgument::REQUIRED, 'L\'email de l\'admin')
            ->addArgument('password', InputArgument::REQUIRED, 'Le mot de passe de l\'admin')
        ;
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $admin = $this->adminUserManager->createAdmin();
        $admin
            ->setUsername($username)
            ->setEmail($email)
            ->setPlainPassword($password)
            ->setEnabled(true)
        ;
        $this->adminUserManager->save($admin);

        $output->write('Création de l\'utilisateur admin.');

        return 0;
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];

        if (!$input->getArgument('username')) {
            $question = new Question('Choisis un pseudo: ');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Le pseudo ne peut être vide');
                }

                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('email')) {
            $question = new Question('Choisis un email: ');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('L\'email ne peut être null');
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Choisis un mot de passe: ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Le mot de passe ne peut être null');
                }

                return $password;
            });
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}