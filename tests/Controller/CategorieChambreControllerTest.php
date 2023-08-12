<?php

namespace App\Test\Controller;

use App\Entity\CategorieChambre;
use App\Repository\CategorieChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategorieChambreControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CategorieChambreRepository $repository;
    private string $path = '/categorie/chambre/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(CategorieChambre::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CategorieChambre index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'categorie_chambre[categoryName]' => 'Testing',
            'categorie_chambre[catdescription]' => 'Testing',
        ]);

        self::assertResponseRedirects('/categorie/chambre/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CategorieChambre();
        $fixture->setCategoryName('My Title');
        $fixture->setCatdescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CategorieChambre');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CategorieChambre();
        $fixture->setCategoryName('My Title');
        $fixture->setCatdescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'categorie_chambre[categoryName]' => 'Something New',
            'categorie_chambre[catdescription]' => 'Something New',
        ]);

        self::assertResponseRedirects('/categorie/chambre/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCategoryName());
        self::assertSame('Something New', $fixture[0]->getCatdescription());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new CategorieChambre();
        $fixture->setCategoryName('My Title');
        $fixture->setCatdescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/categorie/chambre/');
    }
}
