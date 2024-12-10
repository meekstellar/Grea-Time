// Перезавантаження сторінки
if (typeof window.refresh_time_out !== 'undefined') {
    let inactivityTime = refresh_time_out * 60 * 1000; // 5 хвилин у мілісекундах
    let timeout;

    // Функція для перезавантаження сторінки
    function reloadPage() {
        location.reload();
    }

    // Функція для скидання таймера
    function resetTimer() {
        clearTimeout(timeout); // Очищуємо попередній таймер
        timeout = setTimeout(reloadPage, inactivityTime); // Встановлюємо новий таймер
    }

    // Додаємо слухачів подій для відстеження активності
    function setupActivityListeners() {
        document.addEventListener('mousemove', resetTimer); // Рух миші
        document.addEventListener('keydown', resetTimer); // Натискання клавіш
        document.addEventListener('mousedown', resetTimer); // Клік миші
        document.addEventListener('touchstart', resetTimer); // Дотик на сенсорному екрані
    }

    // Запуск механізму відстеження активності
    function startInactivityTimer() {
        setupActivityListeners();
        resetTimer(); // Запускаємо таймер вперше
    }

    // Ініціалізація
    startInactivityTimer();
}
