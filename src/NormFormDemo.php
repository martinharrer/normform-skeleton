<?php

namespace NormFormSkeleton;

use Fhooe\NormForm\Core\AbstractNormForm;
use Fhooe\NormForm\Parameter\GenericParameter;
use Fhooe\NormForm\Parameter\PostParameter;

class NormFormDemo extends AbstractNormForm
{

    /** Form field constant that defines how the form field for holding a first name is called (id/name). */
    public const FIRST_NAME = "firstname";

    /** Form field constant that defines how the form field for holding a last name is called (id/name). */
    public const LAST_NAME = "lastname";

    /** Form field constant that defines how the form field for holding a message is called (id/name). */
    public const MESSAGE = "message";

    /**
     * Holds the results of the form submission (assigned in business()).
     *
     * @var array
     */
    private $result;

    /**
     * Validates the form submission. The criteria for this example are non-empty fields for first and last name.
     * These are checked using isEmptyPostField() in two separate if-clauses.
     * If a criterion is violated, an entry in errorMessages is created.
     * The array holding these error messages is then added to the parameters of the current view. If no error
     * messages where created, validation is seen as successful.
     *
     * @return bool Returns true if validation was successful, otherwise false.
     */
    protected function isValid(): bool
    {
        if ($this->isEmptyPostField(self::FIRST_NAME)) {
            $this->errorMessages[self::FIRST_NAME] = "First name is required.";
        }
        if ($this->isEmptyPostField(self::LAST_NAME)) {
            $this->errorMessages[self::LAST_NAME] = "Last name is required.";
        }

        $this->currentView->setParameter(new GenericParameter("errorMessages", $this->errorMessages));

        return (count($this->errorMessages) === 0);
    }

    /**
     * Business logic method used to process the data that was used after a successful validation. In this example the
     * received data is stored in result and passed on to the view. In more complex scenarios this would be the
     * place to add things to a database or perform other tasks before displaying the data.
     */
    protected function business(): void
    {
        $this->result = $_POST;
        $this->currentView->setParameter(new GenericParameter("result", $this->result));

        $this->statusMessage = "Processing successful!";
        $this->currentView->setParameter(new GenericParameter("statusMessage", $this->statusMessage));

        // Update the three form parameters with empty content so that the form fields are empty upon result display.
        $this->currentView->setParameter(new PostParameter(self::FIRST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::LAST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::MESSAGE, true));
    }
}
