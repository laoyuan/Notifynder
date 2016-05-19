<?php

namespace Fenos\Notifynder\Models;

use Fenos\Notifynder\Contracts\NotifynderTranslator;
use Fenos\Notifynder\Exceptions\NotificationTranslationNotFoundException;
use Fenos\Notifynder\Parsers\NotifynderParser;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class NotifynderCollection.
 */
class NotifynderCollection extends Collection
{
    /**
     * This method translate the body text from
     * another language. It used by collection.
     *
     * @deprecated just hold here for compatibility
     * @return NotifynderCollection
     */
    public function translate()
    {
        $this->parse();

        return $this;
    }

    /**
     * Parse the body of the notification.
     *
     * @return NotifynderCollection
     */
    public function parse()
    {
        $parser = new NotifynderParser();

        foreach ($this->items as $key => $item) {
            $this->items[$key]['text'] = $parser->parse($item);
        }

        return $this;
    }
}
