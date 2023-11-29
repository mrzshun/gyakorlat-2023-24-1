const isOdd = require('is-odd');
const isisOdd = require('is-is-odd');
console.log(isOdd('1'));
console.log(isisOdd('1'));
console.log(isisOdd(isOdd));
console.log(isisOdd(() => {}));