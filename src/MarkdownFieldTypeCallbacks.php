<?php namespace Anomaly\MarkdownFieldType;

use Anomaly\MarkdownFieldType\Command\DeleteDirectory;
use Anomaly\MarkdownFieldType\Command\PutFile;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class MarkdownFieldTypeCallbacks
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MarkdownFieldType
 */
class MarkdownFieldTypeCallbacks
{

    use DispatchesCommands;

    /**
     * Fired after an entry is saved.
     *
     * @param MarkdownFieldType $fieldType
     */
    public function onEntrySaved(MarkdownFieldType $fieldType)
    {
        if (!$fieldType->getLocale()) {
            $this->dispatch(new PutFile($fieldType));
        }
    }

    /**
     * Fired after an entry translation is saved.
     *
     * @param MarkdownFieldType $fieldType
     */
    public function onEntryTranslationSaved(MarkdownFieldType $fieldType)
    {
        $this->dispatch(new PutFile($fieldType));
    }

    /**
     * Fired after an entry is deleted.
     *
     * @param MarkdownFieldType $fieldType
     */
    public function onEntryDeleted(MarkdownFieldType $fieldType)
    {
        if (!$fieldType->getLocale()) {
            $this->dispatch(new DeleteDirectory($fieldType));
        }
    }

    /**
     * Fired after an entry translation is deleted.
     *
     * @param MarkdownFieldType $fieldType
     */
    public function onEntryTranslationDeleted(MarkdownFieldType $fieldType)
    {
        $this->dispatch(new DeleteDirectory($fieldType));
    }
}
