/* basic variables */
var stringVariable = "Hello world";
var numberVariable = 1.2345;
var boolVariable = false;
console.log(stringVariable, numberVariable, boolVariable);
/* arrays */
var arrayVariable = [1,2,3,4,'This is an array', false, true, [10,20,30]];
console.log(arrayVariable);
/* reference to a function */
var functionVariable = function(param) {
    alert(param);
};
functionVariable("Call a function");
/* object */
var objectVariable = {
    key: "value",
    number: 123,
    nestedObject: {
        boolean: false
    },
    method: functionVariable
};
console.log(objectVariable);
console.log(objectVariable.number);
objectVariable.method("Calling a method of object.");