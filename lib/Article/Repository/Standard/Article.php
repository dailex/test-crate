<?php

namespace Dlx\Testing\Article\Repository\Standard;

use Daikon\ReadModel\Projection\ProjectionInterface;
use Daikon\ReadModel\Projection\ProjectionTrait;
use Dlx\Testing\Article\Domain\Event\ArticleWasCreated;
use Dlx\Testing\Article\Domain\Event\ArticleWasUpdated;

final class Article implements ProjectionInterface
{
    use ProjectionTrait;

    public function getTitle()
    {
        return $this->state['title'];
    }

    public function getContent()
    {
        return $this->state['content'];
    }

    private function whenArticleWasCreated(ArticleWasCreated $articleWasCreated)
    {
        return self::fromNative(array_merge(
            $this->state,
            [
                'aggregateId' => $articleWasCreated->getAggregateId()->toNative(),
                'aggregateRevision' => $articleWasCreated->getAggregateRevision()->toNative(),
                'title' => $articleWasCreated->getTitle()->toNative(),
                'content' => $articleWasCreated->getContent()->toNative()
            ]
        ));
    }

    private function whenArticleWasUpdated(ArticleWasUpdated $articleWasUpdated)
    {
        return self::fromNative(array_merge(
            $this->state,
            [
                'aggregateRevision' => $articleWasUpdated->getAggregateRevision()->toNative(),
                'title' => $articleWasUpdated->getTitle()->toNative(),
                'content' => $articleWasUpdated->getContent()->toNative()
            ]
        ));
    }
}
