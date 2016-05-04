<?php

class NotifynderFacadeTest extends TestCaseDB
{
    use CreateModels;

    protected $multiNotificationsNumber = 10;

    protected $to = [
        'id' => 1,
        'type' => Fenos\Tests\Models\User::class
    ];

    /** @test */
    public function testAliasGetAll()
    {
        $category = $this->createCategory(['name' => 'custom']);

        $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $notifications = \Notifynder::getAll($this->to['id']);
        $this->assertCount($this->multiNotificationsNumber, $notifications);
        $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $notifications = \Notifynder::getAll($this->to['id']);
        $this->assertCount($this->multiNotificationsNumber*2, $notifications);
    }

    /** @test */
    public function testAliasReadAll()
    {
        $category = $this->createCategory(['name' => 'custom']);

        $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $readCount = \Notifynder::readAll($this->to['id']);
        $this->assertEquals($this->multiNotificationsNumber, $readCount);
        $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $readCount = \Notifynder::readAll($this->to['id']);
        $this->assertEquals($this->multiNotificationsNumber, $readCount);
        $readCount = \Notifynder::readAll($this->to['id']);
        $this->assertEquals(0, $readCount);
    }

    /** @test */
    public function testAliasSendNotification()
    {
        $category = $this->createCategory(['name' => 'custom']);

        \Notifynder::category($category->name)
            ->from(0)
            ->to($this->to['type'], $this->to['id'])
            ->url('http://www.yourwebsite.com/page')
            ->send();

        $notifications = \Notifynder::getAll($this->to['id']);
        $this->assertCount(1, $notifications);
    }
}