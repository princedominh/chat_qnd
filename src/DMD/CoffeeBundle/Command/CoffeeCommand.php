<?php

namespace DMD\CoffeeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Doctrine\Common\Collections\ArrayCollection;

use DMD\CoffeeBundle\Entity\Item;
use DMD\CoffeeBundle\Entity\ItemPrice;

class CoffeeCommand extends ContainerAwareCommand
{
    private $logger;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('coffee:updateprice');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger = $this->getContainer()->get('logger');
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        
        $this->updatePrice($input, $output, $entityManager);
//        $this->initUserRoleGroup($input, $output, $entityManager);
        
//        $this->initPayment($input, $output, $entityManager);
    }

    private function updatePrice(InputInterface $input, OutputInterface $output, $entityManager)
    {
        $logger = $this->logger;
//        $logger->info('da co');
        $items = $entityManager->getRepository("DMDCoffeeBundle:Item")
                ->findAll();
        if ($items) {
            foreach($items as $item) {
                //find the newest price
                $price = $entityManager->getRepository("DMDCoffeeBundle:ItemPrice")
                        ->findNewestPrice($item->getId());
                //$logger->info(print_r($price));
            }
        }
    }
    
    private function initUserRoleGroup(InputInterface $input, OutputInterface $output, $entityManager)
    {
        //setup group
        $groupnames = array("Super_Admin");
        $cnt = count($groupnames);
        $gres = $entityManager->getRepository("ApplicationSonataUserBundle:Group");
        
        for ($i = 0; $i < $cnt; $i++)
        {
            $groupname = $groupnames[$i];
            $group = $gres->findOneBy(array('name' => $groupname));
            if (!$group) {
                $group = new Group("ROLE_ADMIN");
                $prefix = 'create';
            } else {
                $prefix = 'update';
            }
            $group->setName($groupname);
            $group->setRoles(array("ROLE_ADMIN","ROLE_SUPER_ADMIN"));
            $entityManager->persist($group);
            $entityManager->flush();
            $output->writeln($prefix . " group $groupname");
        }
        $group = $gres->findOneBy(array('name' => $groupnames[0]));
        
        $user = $entityManager->getRepository("ApplicationSonataUserBundle:User")->findOneBy(array('username' => 'admin'));
        if (!$user) {
            $prefix = 'create';
            $user = new User();
        } else {
            $prefix = 'update';
        }
        $user->setUsername('admin');
        $user->setPlainPassword('password123');
        $user->setEnabled(true);
        $user->setFirstname('Prince');
        $user->setLastname('Do Minh');
        $user->setEmail('master@dohoang.net');
        $groups_collection = new ArrayCollection();
        $groups_collection->add($group);
        $user->setGroups($groups_collection);
        $entityManager->persist($user);
        $entityManager->flush();
        $output->writeln($prefix . ' user: username=admin, password=password123');       
    }
}
