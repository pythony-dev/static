$(document).ready(() => {
    const timeChart = new Chart($("#home-time")[0].getContext("2d"), {
        type : "line",
        data : {
            labels : ["A", "B", "C", "D", "E"],
            datasets : [{
                label : "Productivity Chart 1",
                data : [20, 50, 70, 80, 80],
                fill : false,
                borderColor : "#FF6384FF",
                tension : 0.1,
            }, {
                label : "Productivity Chart 2",
                data : [80, 70, 50, 20, 20],
                fill : false,
                borderColor : "#36A2EBFF",
                tension : 0.1,
            }],
        }, options : {
            scales : {
                y : {
                    min : 0,
                    max : 100,
                },
            }, plugins : {
                legend : {
                    display : false,
                },
            },
        },
    })

    const productivityChart = new Chart($("#home-productivity")[0].getContext("2d"), {
        type : "bar",
        data : {
            labels : ["A", "B", "C", "D", "E"],
            datasets : [{
                label : "Time Chart",
                data : [20, 35, 50, 65, 80],
                backgroundColor : ["#FF63843F", "#36A2EB3F", "#FFCE563F", "#4BC0C03F", "#9966FF3F"],
                borderColor : ["#FF6384FF", "#36A2EBFF", "#FFCE56FF", "#4BC0C0FF", "#9966FFFF"],
                borderWidth : 1,
            }],
        }, options : {
            scales : {
                y : {
                    min : 0,
                    max : 100,
                },
            }, plugins : {
                legend : {
                    display : false,
                },
            },
        },
    })
})