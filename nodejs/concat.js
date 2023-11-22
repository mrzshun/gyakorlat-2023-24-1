const { readdir:pReadDir, readFile:pReadFile, writeFile: pWriteFile } = require('fs/promises');
const { join } = require('path');

(async () => {
    const files = await pReadDir('./input');
    const contents = await Promise.all(
        files.map(file => pReadFile("./input/".concat(file),'utf-8'))
    );
    let output = contents.join('\n');
    await pWriteFile('./output/asyncawait.txt',output);
    console.log('end'); 
}) ();

// pReadDir('./input')
//     .then(files => {
//         return Promise.all(
//             files.map(file => pReadFile("./input/".concat(file),'utf-8'))
//         );
//     })
//     .then((contents) => {
//         let output = contents.join('\n');
//         return pWriteFile('./output/promise.txt',output);
//     })
//     .then(() => {
//         console.log('file created');
//         console.log('end');
//     });

// const { join } = require('path');
// let files = readdir('./input', (error,files) => {
//     if(error) throw error;
//     const contents = [];
//     files.forEach(file => {
//         //console.log(file);
//         readFile("./input/".concat(file),'utf-8',(error,content) => {
//             if(error) throw error;
//             //console.log(content.toString());
//             contents.push(content);
//             if(contents.length == files.length) {
//                 let output = contents.join('\n');
//                 writeFile('./output/callback.txt',output,(error) => {
//                     if(error) throw error;
//                     console.log('file created');
//                     console.log('end');
//                 })
//             }
//         });
//     })
// });
// //console.log('end');