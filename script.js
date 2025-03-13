// Кнопка для сохранения в PDF файл
document.getElementById("downloadPDFbtn").addEventListener('click', () => {
    // Опции для PDF файла
    const date = new Date();
    let day = date.getDate();
    let month = date.getMonth()+1;
    let year = date.getFullYear();
    let fullDate = `${day}-${month}-${year}`;
    const options = {
        margin: 0,
        filename: `dashboard_results_${fullDate}.pdf`,
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'in', compress: true, format: 'letter', orientation: 'portrait' },
    };
    html2pdf().set(options).from(document.getElementById('tableResults')).save();
})

// Ссылка на репозиторий используемой библиотеки:
// https://github.com/eKoopmans/html2pdf.js 