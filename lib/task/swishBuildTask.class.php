<?php

class swishBuildTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      //new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      //new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      //new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'swish';
    $this->name             = 'build';
    $this->briefDescription = 'Builds the swish index';
    $this->detailedDescription = <<<EOF
The [swish:build|INFO] task builds the swish index.
Call it with:

  [php symfony swish:build|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    //$databaseManager = new sfDatabaseManager($this->configuration);
    //$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here

    if (!file_exists("data/swish"))
    {
      mkdir("data/swish");
    }

    system("swish-e -c config/swish.config");
  }
}
