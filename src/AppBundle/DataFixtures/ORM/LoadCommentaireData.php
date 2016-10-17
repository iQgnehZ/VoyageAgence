<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Commentaire;

class LoadCommantaireData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$circuit=$this->getReference('andalousie-circuit');

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-07-10'));
		$commentaire->setDescription('I love this circuit!!!');
		$commentaire->setUserName('ZHENG Qi');
		$circuit->addCommentaire($commentaire);

		$manager->persist($commentaire);

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-07-11'));
		$commentaire->setDescription('I love this circuit!!!~');
		$commentaire->setUserName('Wang Yuwei');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);

		$circuit=$this->getReference('vietnam-circuit');

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-07-11'));
		$commentaire->setDescription('I love this circuit!!!~');
		$commentaire->setUserName('Dang Yuwei');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);


		$circuit=$this->getReference('idf-circuit');

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-08-11'));
		$commentaire->setDescription('Interesting!!!~');
		$commentaire->setUserName('Wang Yuwei');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);
		
		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-09-11'));
		$commentaire->setDescription('Interesting!!!~');
		$commentaire->setUserName('Wang Yuwei');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);

		$circuit=$this->getReference('italie-circuit');

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-12-11'));
		$commentaire->setDescription('BoringT_T');
		$commentaire->setUserName('Wang Yuwei');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-11-11'));
		$commentaire->setDescription('COLD!!!~');
		$commentaire->setUserName('Zheng Qi');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);

		$commentaire = new Commentaire();
		$commentaire->setDate(new \DateTime('2016-10-11'));
		$commentaire->setDescription('Interesting!~');
		$commentaire->setUserName('Dong Yifang');
		$circuit->addCommentaire($commentaire);
		
		$manager->persist($commentaire);

		$manager->flush();
	}

	public function getOrder()
	{
		// the order in which fixtures will be loaded
		// the lower the number, the sooner that this fixture is loaded
		return 4;
	}
}