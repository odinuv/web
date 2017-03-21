//iterating in array using for...of (new)
var arr = [1,2,3,4,5,6];
for(var i of arr) {
    console.log(i);
}
//another type of iteration using forEach and arrow expression (new in ES 2015)
arr.forEach((i, k) => {
    console.log(i, k);
});
//iterating over object's properties using for...in
var obj = {
    prop1: 'val1',
    prop2: 2
};
for(var k in obj) {
    console.log(k, obj[k]);
}