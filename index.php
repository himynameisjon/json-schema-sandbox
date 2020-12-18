<?php
/**
Objective: Properly define all "monster" object properties to ensure the provided $json data passes validation
Learning resources:
- https://json-schema.org/understanding-json-schema/
- https://github.com/justinrainbow/json-schema
*/ 
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;
use JsonSchema\Constraints\Factory;

$jsonSchema = <<<'JSON'
{
	 "$schema": "http://json-schema.org/schema#",
    "title": "Items",
    "type": "object",
    "additionalProperties": false,
    "definitions": {
        "monster" : {
            "type": "object",
            "additionalProperties": false,
            "properties": {
                // replace this line with your property definitions
            }
        }
    },
    "properties": {
        "units": {
            "type": "array",
            "minItems": 1,
            "items": {
                "$ref": "#/definitions/monster"
            }
        }
    },
    "required": ["units"]
}
JSON;

/***** don't edit beyond this line *****/

/* JSON data */
$json = <<<'JSON'
{
   "units":[
      {
         "id":1001,
         "name":"Fire Lion",
         "attributes":[
            "f"
         ],
         "rarity":1,
         "group_type":"DRAGON",
         "lvl":1,
         "id_monsterdex":null,
         "hatching_time":15,
         "breeding_time":15,
         "costs":{
            "g":100
         },
         "sell_price":{
            "g":50
         }
      },
      {
         "id":1002,
         "name":"Rockilla",
         "attributes":[
            "e"
         ],
         "rarity":1,
         "group_type":"DRAGON",
         "lvl":3,
         "id_monsterdex":5,
         "hatching_time":120,
         "breeding_time":120,
         "costs":{
            "g":600
         },
         "sell_price":{
            "g":150
         }
      },
      {
         "id":1003,
         "name":"Turtle",
         "attributes":[
            "w"
         ],
         "rarity":1,
         "group_type":"DRAGON",
         "lvl":12,
         "id_monsterdex":null,
         "hatching_time":14400,
         "breeding_time":14400,
         "costs":{
            "g":30000
         },
         "sell_price":{
            "g":600
         }
      },
      {
         "id":1004,
         "name":"Panda",
         "attributes":[
            "n"
         ],
         "rarity":1,
         "group_type":"DRAGON",
         "lvl":2,
         "id_monsterdex":null,
         "hatching_time":15,
         "breeding_time":15,
         "costs":{
            "g":400
         },
         "sell_price":{
            "g":100
         }
      }
   ]
}
JSON;

/* Validation code */
validate($json, $jsonSchema);

function validate($json, $jsonSchema) {
	$jsonSchemaObject = json_decode($jsonSchema);
   	$jsonToValidateObject = json_decode($json);

	try {
    	$schemaStorage = new SchemaStorage();
		$schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);
    	$jsonValidator = new Validator( new Factory($schemaStorage));
    	$jsonValidator->validate($jsonToValidateObject, $jsonSchemaObject);
        echo $jsonValidator->isValid() ? 'Success!' : 'Failed...';
        var_dump($jsonValidator->getErrors());
	} catch(Exception $e) {
		echo "Your schema probably has an invalid JSON format.";
	}
}