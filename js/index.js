const express = require('express')
const app = express()
const php = require('php')

// setup php templating engine
app.set('views', path.join(__dirname, 'templates'))
app.set('view engine', 'php')
app.engine('php', php.__express)

// define a route
app.get('/', (req, res) => {
    res.render('index.php', {
        hello: 'world'
    })
})