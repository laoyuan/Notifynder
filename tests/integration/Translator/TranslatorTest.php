<?php

use Fenos\Notifynder\Translator\TranslatorManager;

/**
 * Class TranslatorTest
 */
class TranslatorTest extends TestCaseDB {

    use CreateModels;

    /**
     * @var TranslatorManager
     */
    protected $translator;

    /**
     * @var int
     */
    protected $multiNotificationsNumber = 10;

    /**
     * @var array
     */
    protected $to = [
        'id' => 1,
        'type' => 'Fenos\Tests\Models\User'
    ];

    /**
     * Set Up
     */
    public function setUp()
    {
        parent::setUp();

        $translations = require('translations.php');

        app('config')->set('notifynder.translations',$translations);
        $this->translator = app('notifynder.translator');
    }

    /** @test */
    function it_translate_a_notification()
    {
        $translation = $this->translator->translate('it', 'welcome');
        $this->assertEquals('benvenuto', $translation);
        $translation = $this->translator->translate('de', 'welcome');
        $this->assertEquals('willkommen', $translation);
    }

    /** @test */
    function it_translate_notifynder_collection()
    {
        $category = $this->createCategory(['text' => 'welcome', 'name' => 'welcome']);

        $notifications = $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $notifications = new \Fenos\Notifynder\Models\NotifynderCollection($notifications);

        $this->assertInstanceOf(\Fenos\Notifynder\Models\NotifynderCollection::class, $notifications);

        $translations = $notifications->translate('it');
        $texts = $translations->pluck('text')->unique();
        $this->assertCount(1, $texts);
        $this->assertEquals('benvenuto', $texts->first());

        $translations = $notifications->translate('de');
        $texts = $translations->pluck('text')->unique();
        $this->assertCount(1, $texts);
        $this->assertEquals('willkommen', $texts->first());
    }

    /** @test */
    function it_translate_notifynder_collection_fail()
    {
        $category = $this->createCategory(['text' => 'test_fail', 'name' => 'test_fail']);

        $notifications = $this->createMultipleNotifications(['category_id' => $category->getKey()]);
        $notifications = new \Fenos\Notifynder\Models\NotifynderCollection($notifications);

        $this->assertInstanceOf(\Fenos\Notifynder\Models\NotifynderCollection::class, $notifications);

        $translations = $notifications->translate('it');
        $texts = $translations->pluck('text')->unique();
        $this->assertCount(1, $texts);
        $this->assertEquals('test_fail', $texts->first());

        $this->setExpectedException(\Fenos\Notifynder\Exceptions\NotificationLanguageNotFoundException::class);
        $notifications->translate('abc');
    }
}