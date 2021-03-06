<?php

namespace Lichess\TranslationBundle;
use Lichess\TranslationBundle\Document\TranslationRepository;

class Provider
{
    protected $repository;

    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTranslations($start = 1)
    {
        $translations = array();
        foreach($this->repository->findAllSortByCreatedAt() as $translation) {
            if($id = $translation->getNumericId()) {
                if($id >= $start && $translation->getCode()) {
                    $translations[$id] = array(
                        'code' => $translation->getCode(),
                        'author' => $translation->getAuthor(),
                        'comment' => $translation->getComment(),
                        'date' => $translation->getCreatedAt() ? $translation->getCreatedAt()->format('Y-m-d H:i:s') : '?',
                        'messages' => $translation->getMessages()
                    );
                }
            }
        }

        return $translations;
    }
}
