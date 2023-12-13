const { User, Post, Category } = require("./models");
(async () => {
    // console.log(await User.findAll());
    // console.log(await (await User.findByPk(1)).getPosts());
    // console.log(await (await Post.findByPk(1)).getCategories());
    // console.log(await (await Post.findByPk(1)).countCategories());
    console.log(
        //JSON.stringify(
            await Post.findAll({
                attributes: ["id","title"],
                include: [
                    {
                        model: Category,
                        as: "Categories",
                        attributes: ["id","name"],
                        through: { attributes: [] }
                    }
                ]
            })
        //)
    );
})
()