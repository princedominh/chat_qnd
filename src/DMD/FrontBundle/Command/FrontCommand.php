<?php

namespace DMD\FrontBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Doctrine\Common\Collections\ArrayCollection;

use DMD\FrontBundle\Entity\Setting;

class FrontCommand extends ContainerAwareCommand
{
    private $logger;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('front:setting');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger = $this->getContainer()->get('logger');
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        
        $this->settings($input, $output, $entityManager);

    }

    private function settings(InputInterface $input, OutputInterface $output, $entityManager)
    {
        $logger = $this->logger;
//        $logger->info('da co');
        $settings = array(
          array("slug"=> "items_per_page_inventory",
              "data_type"=> "integer",
              "value"=> 25,
              "description"=>"items_per_page_inventory"),
          array("slug"=> "items_per_page_analysis",
              "data_type"=> "integer",
              "value"=> 100,
              "description"=>"items_per_page_analysis"),
        );
        $settingRepo = $entityManager->getRepository("DMDFrontBundle:Setting");
        foreach($settings as $setting) {
            $setE = $settingRepo->findOneBy(array('slug' => $setting["slug"]));
            $prefix = 'create';
            if($setE) {
                $prefix = 'update';
                $setE->setSettingValue($setting["data_type"],$setting["value"],$setting["description"]);
            } else {
                $setE = new Setting($setting["slug"],$setting["data_type"],$setting["value"],$setting["description"]);
            }
            $entityManager->persist($setE);
            $output->writeln($prefix.' setting: '.$setE->getSlug(). ' is ' . $setE->getSettingValue() . ' ('.$setE->getDataType().')');
        }
        
        $entityManager->flush();
    }

}
