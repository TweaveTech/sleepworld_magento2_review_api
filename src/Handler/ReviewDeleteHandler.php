<?php

namespace Tweave\ReviewApi\Handler;

use Magento\Framework\Exception\NoSuchEntityException;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewDeleteHandler
{
    public function __construct(
        protected ReviewHelper $reviewHelper
    ) { }

    /**
     * @param  int  $id
     *
     * @return true
     * @throws NoSuchEntityException
     */
    public function __invoke(int $id): bool
    {
        $review = $this->reviewHelper->getReview($id);
        $review->aggregate()->delete();

        return true;
    }

}
