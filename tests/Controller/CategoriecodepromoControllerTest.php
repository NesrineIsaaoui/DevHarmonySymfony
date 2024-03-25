<?php

namespace App\Test\Controller;

use App\Entity\Categoriecodepromo;
use App\Repository\CategoriecodepromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoriecodepromoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CategoriecodepromoRepository $repository;
    private string $path = '/categoriecodepromo/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Categoriecodepromo::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Categoriecodepromo index');

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
            'categoriecodepromo[code]' => 'Testing',
            'categoriecodepromo[value]' => 'Testing',
            'categoriecodepromo[nbUsers]' => 'Testing',
        ]);

        self::assertResponseRedirects('/categoriecodepromo/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Categoriecodepromo();
        $fixture->setCode('My Title');
        $fixture->setValue('My Title');
        $fixture->setNbUsers('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Categoriecodepromo');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Categoriecodepromo();
        $fixture->setCode('My Title');
        $fixture->setValue('My Title');
        $fixture->setNbUsers('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'categoriecodepromo[code]' => 'Something New',
            'categoriecodepromo[value]' => 'Something New',
            'categoriecodepromo[nbUsers]' => 'Something New',
        ]);

        self::assertResponseRedirects('/categoriecodepromo/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCode());
        self::assertSame('Something New', $fixture[0]->getValue());
        self::assertSame('Something New', $fixture[0]->getNbUsers());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Categoriecodepromo();
        $fixture->setCode('My Title');
        $fixture->setValue('My Title');
        $fixture->setNbUsers('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/categoriecodepromo/');
    }
}
