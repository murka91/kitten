const mysql = require('mysql');

// Функция для получения подробной информации о котенке по ID
const fetchKittenDetails = (connection, kittenId) => {
    const fetchKittenQuery = 'SELECT * FROM kittens WHERE id = ?;';
    connection.query(fetchKittenQuery, [kittenId], (err, results) => {
        if (err) {
            console.error('Ошибка при выполнении запроса: ' + err.stack);
            return;
        }
        if (results.length > 0) {
            const kitten = results[0];
            console.log(`\nДетали котенка (ID: ${kitten.id}):`);
            console.log(`Имя: ${kitten.name}`);
            console.log(`Возраст: ${kitten.age} месяцев`);
            console.log(`Пол: ${kitten.gender}`);
            console.log(`URL изображения: ${kitten.image_url}`);
            console.log(`Описание: ${kitten.description}`);
            console.log(`История болезни: ${kitten.medical_history}`);
            console.log(`Обучение: ${kitten.training}`);
            console.log(`Предпочтения: ${kitten.preferences}`);
            console.log(`Статус: ${kitten.status}`);
        } else {
            console.log('Котенок с таким ID не найден.');
        }
    });
};

