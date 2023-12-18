const { User, Post, Category } = require("./models");
const { readFileSync } = require("fs");
var md5 = require('md5');
const mercurius = require('mercurius');


const fastify = require('fastify')({
    logger: true
})

const context = (request) => {
    return {
        request,
    };
};

fastify.register(mercurius, {
    schema: readFileSync("./gql/schema.gql").toString(),
    resolvers: require("./gql/resolvers"),
    graphiql: true,
    context,
    // A fastify-hez érkezett kérést berakjuk a context-be
})


// fastify.addHook('onRequest', async (request, reply) => {
//     try {
//         await request.jwtVerify();
//     } catch (err) {
//         reply.send(err);
//     }
// })

fastify.register(require('@fastify/jwt'), {
    secret: 'secret'
});

fastify.post('/login', {
    schema: {
        body: {
            type: 'object',
            required: ['email', 'password'],
            properties: {
                email: { type: 'string' },
                password: { type: 'string' }
            }
        }
    }
}, async (request, reply) => {
    const { email, password } = request.body;
    const user = await User.findOne({ where: { email: email } });
    if (!user) {
        return reply.status(401).send({ message: "user does not exist" });
    } else if (user.password != md5(password)) {
        return reply.status(401).send({ message: "user's password does not match" });
    } else {
        const token = fastify.jwt.sign({ payload: user.toJSON() });
        return reply.send({ token });
    }
})


// Declare a route
fastify.get('/', (request, reply) => {
    reply.send({ hello: 'world2' })
})

fastify.get('/categories', async (request, reply) => {
    const categories = await Category.findAll();
    reply.send(categories);
})

fastify.get('/categories/:id', {
    schema: {
        params: {
            type: 'object',
            properties: {
                id: { type: 'number' }
            }
        }
    }
}, async (request, reply) => {
    const category = await Category.findByPk(request.params.id);
    if (category == null) {
        return reply.status(404).send({ message: "There is no category with the given ID - ".concat(request.params.id) });
    }
    reply.send(category);
})

fastify.decorate("authenticate", async (request, reply) => {
    try {
        await request.jwtVerify();
    } catch (err) {
        reply.send(err);
    }
})

fastify.get("/who", {
    onRequest: [fastify.authenticate],
},
async (request,reply) => {
    reply.send(request.user);
})

fastify.post('/categories', {
    onRequest: [fastify.authenticate],
    schema: {
        body: {
            type: 'object',
            required: ['name', 'color'],
            properties: {
                name: { type: 'string' },
                color: { type: 'string', pattern: '^#[0-9a-fA-F]{6}$' }
            }
        }
    }
}, async (request, reply) => {
    const { name, color } = request.body;
    const category = await Category.create({ name, color });
    reply.send(category);
})

fastify.put('/categories/:id', {
    schema: {
        params: {
            type: 'object',
            properties: {
                id: { type: 'number' }
            }
        },
        body: {
            type: 'object',
            required: ['name', 'color'],
            properties: {
                name: { type: 'string' },
                color: { type: 'string', pattern: '^#[0-9a-fA-F]{6}$' }
            }
        }
    }
}, async (request, reply) => {
    const category = await Category.findByPk(request.params.id);
    if (category == null) {
        return reply.status(404).send({ message: "There is no category with the given ID - ".concat(request.params.id) });
    }
    const { name, color } = request.body;
    await category.update({ name, color });
    reply.send(category);
})


fastify.patch('/categories/:id', {
    schema: {
        params: {
            type: 'object',
            properties: {
                id: { type: 'number' }
            }
        },
        body: {
            type: 'object',
            properties: {
                name: { type: 'string' },
                color: { type: 'string', pattern: '^#[0-9a-fA-F]{6}$' }
            }
        }
    }
}, async (request, reply) => {
    const category = await Category.findByPk(request.params.id);
    if (category == null) {
        return reply.status(404).send({ message: "There is no category with the given ID - ".concat(request.params.id) });
    }
    const { name, color } = request.body;
    await category.update({ name, color });
    reply.send(category);
})

fastify.delete('/categories', async (request, reply) => {
    await Category.destroy({
        where: {}
    });
    reply.send(204);
})

fastify.delete('/categories/:id', {
    schema: {
        params: {
            type: 'object',
            properties: {
                id: { type: 'number' }
            }
        }
    }
}, async (request, reply) => {
    const category = await Category.findByPk(request.params.id);
    if (category == null) {
        return reply.status(404).send({ message: "There is no category with the given ID - ".concat(request.params.id) });
    }
    category.destroy();
    reply.send(204);
})



// Run the server!
fastify.listen({ port: 3000 }, (err, address) => {
    if (err) throw err
    // Server is now listening on ${address}
})

// fastify.get('/:id', {
//     schema: {
//         params: {
//             type: 'object',
//             properties: {
//                 id: { type: 'number' }
//             }
//         }
//     }

// }, (request, reply) => {
//     reply.send({ hello: request.params.id })
// })

