var download = document.getElementById('download');
// var invoice = document.getElementById('invoice_data');
window.jsPDF = window.jspdf.jsPDF;

function download_invoice(){
    const content = document.querySelector("#invoice_data");

            // Use html2canvas to capture the content
            html2canvas(content).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const doc = new jsPDF();

                // Add the captured image to the PDF
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 295; // A4 height in mm
                const imgHeight = 290;
                let heightLeft = imgHeight;

                let position = 0;

                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                doc.save('invoice.pdf');
            });
}

download.addEventListener("click",download_invoice);