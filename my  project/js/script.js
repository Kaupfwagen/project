$(function () {
   var priceForm = $('#price-form');
   priceForm.on("submit",function () {
       var data=priceForm.serializeArray();
       console.log(data);
       $.ajax({
           url: "PriceForm.php",
           data: data,
           dataType:"json"
       }).done(function( result ) {
               console.log(result);
               if (result.status === "fail") {
                   alert("Перевірте введені дані\n\n" + result.messages.join("\n"));
               } else {
                   alert("Дякуємо, ми звяжемось з Вами найближчим часом");
                   priceForm[0].reset();
               }

           });
       return false;
   });
});
// $(function () {
//     var contactForm = $('#contact-input');
//     contactForm.on("submit",function () {
//         var data=contactForm.serializeArray();
//         console.log(data);
//         $.ajax({
//             url: "ContactForm.php",
//             data: data,
//             dataType:"json"
//         }).done(function( result ) {
//             console.log(result);
//             if (result.status === "fail") {
//                 alert("Перевірте введені дані\n\n" + result.messages.join("\n"));
//             } else {
//                 alert("Дякуємо, ми звяжемось з Вами найближчим часом");
//                 priceForm[0].reset();
//             }
//
//         });
//         return false;
//     });
// });