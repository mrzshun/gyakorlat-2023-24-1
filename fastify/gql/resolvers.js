const { User, Post, Category } = require("../models");

module.exports = {
    Query: {
        add: async (_,{x,y}) => x+y,
        mult: async (_,{x,y}) => x*y,
        hello: () => { return "world" },
        categories: async () => {
            return await Category.findAll();
        }
    }
}