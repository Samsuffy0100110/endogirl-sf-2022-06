<?php

namespace App\Test\Controller\Forum;

use App\Entity\Forum\Topic;
use App\Repository\Forum\TopicRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TopicControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TopicRepository $repository;
    private string $path = '/forum/topic/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Topic::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Topic index');

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
            'topic[title]' => 'Testing',
            'topic[content]' => 'Testing',
            'topic[reply]' => 'Testing',
            'topic[createdAt]' => 'Testing',
            'topic[subject]' => 'Testing',
            'topic[user]' => 'Testing',
        ]);

        self::assertResponseRedirects('/forum/topic/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Topic();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setReply('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSubject('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Topic');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Topic();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setReply('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSubject('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'topic[title]' => 'Something New',
            'topic[content]' => 'Something New',
            'topic[reply]' => 'Something New',
            'topic[createdAt]' => 'Something New',
            'topic[subject]' => 'Something New',
            'topic[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/forum/topic/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getContent());
        self::assertSame('Something New', $fixture[0]->getReply());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getSubject());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Topic();
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');
        $fixture->setReply('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSubject('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/forum/topic/');
    }
}
