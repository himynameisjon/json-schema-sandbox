<?php require_once('vendor/autoload.php');$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);$dotenv->load();

/**
https://json-schema.org/understanding-json-schema/
https://github.com/justinrainbow/json-schema
*/
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;
use JsonSchema\Constraints\Factory;
$jsonSchema = <<<'JSON'
{
	"$schema": "http://json-schema.org/schema#",
    "type": "object",
    "definitions": {
        "integerData" : {
            "type": "integer",
            "minimum" : 0
        },
        "stringData" : {
            "type": "string"
        }
    },
    "properties": {
        "data": {
            "oneOf": [
                { "$ref": "#/definitions/integerData" },
                { "$ref": "#/definitions/stringData" }
            ]
        }
    },
    "required": ["data"]
}
JSON;
/***** don't edit beyond this line *****/
$json = <<<'JSON'
{
	"data": 1234
}
JSON;
validate($json, $jsonSchema);
function validate($json, $jsonSchema)
{
    $jsonSchemaObject = json_decode($jsonSchema);
    $schemaStorage = new SchemaStorage();
    try {
        $schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);
    } catch (Exception $e) {
        echo "Your schema probably has an invalid JSON format.";
    }
    $jsonValidator = new Validator(new Factory($schemaStorage));
    $jsonToValidateObject = json_decode($json);
    $jsonValidator->validate($jsonToValidateObject, $jsonSchemaObject);
    echo $jsonValidator->isValid() ? 'Success!' : 'Failed...';
    cdump($jsonValidator->getErrors());
}
