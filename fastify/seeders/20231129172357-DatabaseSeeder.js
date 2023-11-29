'use strict';
const { User, Post, Category } = require("../models");
var md5 = require('md5');
const { faker } = require("@faker-js/faker");

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    try {
      const userNum = faker.number.int({ min: 8, max: 10 });
      const users = [];
      for (let i = 0; i < userNum; i++) {
        users.push(
          await User.create({
            name: faker.person.fullName(),
            email: faker.internet.email(),
            password: md5("password"),
          })
        );
      }
      const postNum = faker.number.int({ min: 10, max: 15 });
      for (let i = 0; i < postNum; i++) {
        await Post.create({
          title: faker.lorem.sentence({ min: 4, max: 6 }).slice(0, -1),
          description: faker.lorem.sentences({ min: 2, max: 4 }),
          text: faker.lorem.paragraphs({ min: 3, max: 6 }),
          UserId: faker.helpers.arrayElement(users).id,
        })
      }
      const catNum = faker.number.int({ min: 6, max: 8 });
      for (let i = 0; i < catNum; i++) {
        await Category.create({
          name: faker.lorem.word(),
          color: faker.color.rgb({ casing: 'lower' }),
        })
      }

    } catch (error) {
      console.log("Hiba a seedelésben");
      console.log(error);
    }
    /**
     * Add seed commands here.
     *
     * Example:
     * await queryInterface.bulkInsert('People', [{
     *   name: 'John Doe',
     *   isBetaMember: false
     * }], {});
    */
  },

  async down(queryInterface, Sequelize) {
    /**
     * Add commands to revert seed here.
     *
     * Example:
     * await queryInterface.bulkDelete('People', null, {});
     */
  }
};
