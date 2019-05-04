<?php

namespace Esat\Support\Services;

use Esat\Esat;
use Esat\Support\Model\BaseModel;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class ModelService
 * @package Esat\Support\Services
 */
abstract class ModelService extends BaseService
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * Initialize the service model object.
     */
    abstract public function initModel();

    /**
     * ModelService constructor.
     *
     * @param Esat            $esat
     * @param LoggerInterface $logger
     */
    public function __construct(Esat $esat, LoggerInterface $logger)
    {
        parent::__construct($esat, $logger);
        $this->initModel();
    }

    /**
     * @param array  $parameters
     * @param string $operation
     * @param bool   $updateParameters
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function initModelWithParameters(&$parameters, $operation = '', $updateParameters = true)
    {
        // Initialize model
        $this->initModel();

        // Set parameters
        $this->updateModelWithParameters($parameters, $operation, $updateParameters);
    }

    /**
     * @param array  $parameters
     * @param string $operation
     * @param bool   $updateParameters
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function updateModelWithParameters(&$parameters, $operation = '', $updateParameters = true)
    {
        // Check model
        $this->checkModel($operation);

        // Load parameters to model
        $this->getModel()->loadFromArray($parameters);

        // Update parameters
        $parameters = $updateParameters ? $this->getModel()->toArrayExtended($parameters) : $parameters;
    }

    /**
     * @return BaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param BaseModel $model
     *
     * @return $this
     */
    public function setModel(BaseModel $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * It clears the model and creates a new instance.
     * This function is alias for initModel().
     */
    public function clearModel()
    {
        return $this->model = null;
    }

    /**
     * @param string $operation
     *
     * @throws InvalidArgumentException
     */
    public function checkModel($operation = '')
    {
        if (!$this->getModel()) {
            throw new InvalidArgumentException(sprintf('The Service Model is not set for the required operation [%s::%s].', get_class($this), $operation));
        }
    }
}
