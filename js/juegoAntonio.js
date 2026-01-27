import Konva from "../node_modules/konva/lib/index.js";

const width = 600;
const height = 400;

const stage = new Konva.Stage({
    container: 'container',
    width,
    height
});

// 1️⃣ Layer de fondo
const bgLayer = new Konva.Layer();
stage.add(bgLayer);

// Fondo oscuro
const background = new Konva.Rect({
    x: 0,
    y: 0,
    width,
    height,
    fill: '#222',
    opacity: 0.2
});
bgLayer.add(background);
bgLayer.draw();

// 2️⃣ Layer de ladrillos
const bricksLayer = new Konva.Layer();
stage.add(bricksLayer);

// 3️⃣ Layer de bola y paddle
const gameLayer = new Konva.Layer();
stage.add(gameLayer);

let gameStarted = false;
let score = 0;

// Pantalla de inicio en gameLayer
const startText = new Konva.Text({
    x: width / 2,
    y: height / 2,
    text: 'Presiona ENTER para iniciar',
    fontSize: 26,
    fontFamily: 'Arial',
    fill: 'yellow'
});
startText.offsetX(startText.width() / 2);
startText.offsetY(startText.height() / 2);
gameLayer.add(startText);
gameLayer.draw();

// Puntaje
const scoreText = new Konva.Text({
    x: 10,
    y: 10,
    text: `Puntaje: ${score}`,
    fontSize: 18,
    fontFamily: 'Arial',
    fill: 'white'
});
gameLayer.add(scoreText);

document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !gameStarted) {
        gameStarted = true;
        startText.hide();
        initGame();
        gameLayer.draw();
    }
});

function initGame() {
    const paddleWidth = 120;
    const paddleHeight = 20;
    const paddleSpeed = 10;

    // Barra
    const paddle = new Konva.Rect({
        x: width / 2 - paddleWidth / 2,
        y: height - 30,
        width: paddleWidth,
        height: paddleHeight,
        fill: 'white',
        cornerRadius: 10
    });
    gameLayer.add(paddle);

    // Bola
    const ballRadius = 10;
    const ball = new Konva.Circle({
        x: paddle.x() + paddleWidth / 2,
        y: paddle.y() - ballRadius - 2,
        radius: ballRadius,
        fill: 'red'
    });
    gameLayer.add(ball);

    // Ladrillos
    const brickRows = 5;
    const brickCols = 8;
    const brickWidth = 60;
    const brickHeight = 20;
    const brickPadding = 10;
    const bricks = [];
    const colors = ['#FF5733', '#FFC300', '#DAF7A6', '#33FFBD', '#3380FF'];

    for (let row = 0; row < brickRows; row++) {
        for (let col = 0; col < brickCols; col++) {
            const brick = new Konva.Rect({
                x: col * (brickWidth + brickPadding) + 35,
                y: row * (brickHeight + brickPadding) + 30,
                width: brickWidth,
                height: brickHeight,
                fill: colors[row % colors.length],
                stroke: 'white',
                strokeWidth: 2,
                cornerRadius: 5
            });
            bricksLayer.add(brick);
            bricks.push(brick);
        }
    }
    bricksLayer.draw();

    // Velocidades
    let ballSpeedX = 6;
    let ballSpeedY = -6;
    let ballLaunched = false;
    let moveLeft = false;
    let moveRight = false;

    // Eventos
    function handleKeyDown(e) {
        if (e.key === 'ArrowLeft') moveLeft = true;
        if (e.key === 'ArrowRight') moveRight = true;
        if (e.key === ' ' && !ballLaunched) ballLaunched = true;
    }

    function handleKeyUp(e) {
        if (e.key === 'ArrowLeft') moveLeft = false;
        if (e.key === 'ArrowRight') moveRight = false;
    }

    document.addEventListener('keydown', handleKeyDown);
    document.addEventListener('keyup', handleKeyUp);

    // Colisiones
    function checkCollision() {
        if (ball.x() + ballRadius > width || ball.x() - ballRadius < 0) ballSpeedX *= -1;
        if (ball.y() - ballRadius < 0) ballSpeedY *= -1;
        if (ball.y() + ballRadius > height) {
            ballLaunched = false;
            ball.x(paddle.x() + paddleWidth / 2);
            ball.y(paddle.y() - ballRadius);
            ballSpeedX = 6;
            ballSpeedY = -6;
        }

        // Paddle
        if (
            ball.y() + ballRadius >= paddle.y() &&
            ball.x() >= paddle.x() &&
            ball.x() <= paddle.x() + paddleWidth
        ) {
            ballSpeedY *= -1;
            const deltaX = ball.x() - (paddle.x() + paddleWidth / 2);
            ballSpeedX = deltaX * 0.15;
        }

        // Ladrillos
        let bricksHit = false;
        bricks.forEach((brick) => {
            if (!brick.visible()) return;
            if (
                ball.x() + ballRadius > brick.x() &&
                ball.x() - ballRadius < brick.x() + brickWidth &&
                ball.y() + ballRadius > brick.y() &&
                ball.y() - ballRadius < brick.y() + brickHeight
            ) {
                ballSpeedY *= -1;
                brick.hide();
                bricksHit = true;
                score += 10;
                scoreText.text(`Puntaje: ${score}`);
            }
        });
    }

    // Animación
    function animate() {
        if (moveLeft) paddle.x(Math.max(0, paddle.x() - paddleSpeed));
        if (moveRight) paddle.x(Math.min(width - paddleWidth, paddle.x() + paddleSpeed));

        if (!ballLaunched) {
            ball.x(paddle.x() + paddleWidth / 2);
            ball.y(paddle.y() - ballRadius - 2);
        } else {
            ball.x(ball.x() + ballSpeedX);
            ball.y(ball.y() + ballSpeedY);
        }

        checkCollision();
        gameLayer.draw(); // solo redraw la bola/paddle
        requestAnimationFrame(animate);
    }

    animate();
}