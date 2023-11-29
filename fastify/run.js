const { User, Post, Category } = require("./models");
(async () => {
    // console.log(await User.findAll());
    console.log(await (await User.findByPk(1)).getPosts());
})
()