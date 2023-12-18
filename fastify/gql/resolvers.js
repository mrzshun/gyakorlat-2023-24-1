const { User, Post, Category } = require("../models");
const auth = require("./auth");

module.exports = {
    Query: {
        add: async (_,{x,y}) => x+y,
        mult: async (_,{x,y}) => x*y,
        hello: () => { return "world" },
        categories: async () => {
            return await Category.findAll();
        },
        posts: async () => {
            return await Post.findAll();
        },
        who: auth(
            (parent,params,context) => {
                return `Hello ${context.request.user.payload.email}`
            }
        )
    },
    Post: {
        categories: async (post) => await post.getCategories()
    },
    Category: {
        posts: async (category) => await category.getPosts()
    },
    Mutation: {
        createCategory: auth(async(_,{category},context) => {
            return(
                await Category.create(
                    {
                        name:category.name,
                        color:category.color
                    }
                )
            );
        }),
        createPost: auth(async(_,{post},context) => {
            const newPost = await Post.create({
                    title: post.title,
                    description: post.description,
                    text: post.text,
                    UserId: context.request.user.payload.id,
            });
            //await newPost.setCategories(post.categories);
            const postCat = [];
            for(const catId of post.categories) {
                postCat.push(await Category.findByPk(catId));
            }
            await newPost.setCategories(postCat);
            return newPost;
        }),
        updatePost: auth(async(_,{post},context) => {
            const updatedPost = await Post.findByPk(post.id);
            if(updatedPost.UserId != context.request.user.payload.id) return null;
            await updatedPost.update({
                title: post.title,
                description: post.description,
                text: post.text,
            });
            await updatedPost.setCategories(post.categories);
            return updatedPost;
        }),
    }
}