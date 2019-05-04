# e-satisfaction SDK - Code of Conduct

This document will describe some basic rules for writing code in the SDK.

## Building Services ##

In order to write the Service, a Model and a Service have to be created.

### Writing a new Model ###

All models reside in the `src/Model` directory, under the `\Esat\Model` namespace.

Writing a new Model class, we should be have in mind the following:
* All Model classes extend the `\Esat\Model\BaseModel` class.
* Create all properties based on the database column names (taken form the API).
* Set all properties as `protected`.
* Generate all setters and getters for all properties.
* All setters should be fluent.
* Remove the return annotation from all the functions (: anything).
* Set all fluent setters to return `$this` instead of the Model name.
* For any properties that are dates or date-times, add an extra getter with the suffix `AsDateTime` to convert the string to a `DateTime` object.

No tests are needed for the models.

### Writing a new Service ###

All models reside in the `src/Services` directory, under the `\Esat\Services` namespace.

Writing a new Service class, we should be have in mind the following:
* All Service classes extend the `\Esat\Services\HttpService` class.
* Create an extra getter with a friendly name that will call `getModel()` with a specific return type (its own model).

## Tests ##

Write tests for all the Services.

Each service should be tested against the proper API requests that it makes. It should include:
* API method
* API uri
* API response (optional)
