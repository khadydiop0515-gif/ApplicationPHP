/*
Template Name: Color Admin - Responsive Admin Dashboard Template
Version: 4.7.0
Optimisé pour Goorgoorlu - Correction Moment.js & Sécurité d'initialisation
*/

// 1. Gestion du Sparkline des ventes (Optionnel - Vérifie si l'ID existe)
var handleTotalSalesSparkline = function() {
	if ($('#total-sales-sparkline').length !== 0) {
		var options = {
			chart: { type: 'line', width: 200, height: 36, sparkline: { enabled: true }, stacked: true },
			stroke: { curve: 'smooth', width: 3 },
			fill: { type: 'gradient', gradient: { opacityFrom: 1, opacityTo: 1, colorStops: [{ offset: 0, color: COLOR_BLUE, opacity: 1 }, { offset: 100, color: COLOR_INDIGO, opacity: 1 }] } },
			series: [{ data: [9452.37, 11018.87, 7296.37, 6274.29, 7924.05, 6581.34, 12918.14] }],
			tooltip: { theme: 'dark', fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return '' } }, formatter: (value) => { return '$'+ value }, }, marker: { show: false } }
		};
		new ApexCharts(document.querySelector('#total-sales-sparkline'), options).render();
	}
};

// 2. Gestion du filtre de date (CORRIGÉ POUR MOMENT.JS)
var handleDateRangeFilter = function() {
	if ($('#daterange-filter').length !== 0) {
		// CORRECTION DES DEPRECATIONS : Le chiffre passe AVANT l'unité 'days'
		$('#daterange-filter span').html(moment().subtract(7, 'days').format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));
		$('#daterange-prev-date').html(moment().subtract(15, 'days').format('D MMMM') + ' - ' + moment().subtract(8, 'days').format('D MMMM YYYY'));

		$('#daterange-filter').daterangepicker({
			format: 'MM/DD/YYYY',
			startDate: moment().subtract(7, 'days'),
			endDate: moment(),
			minDate: '01/01/2021',
			maxDate: moment().format('MM/DD/YYYY'),
			dateLimit: { days: 60 },
			showDropdowns: true,
			showWeekNumbers: true,
			timePicker: false,
			ranges: {
				'Aujourd\'hui': [moment(), moment()],
				'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'7 derniers jours': [moment().subtract(6, 'days'), moment()],
				'30 derniers jours': [moment().subtract(29, 'days'), moment()],
				'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
				'Mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			opens: 'right',
			drops: 'down',
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-primary',
			cancelClass: 'btn-default',
			locale: {
				applyLabel: 'Valider',
				cancelLabel: 'Annuler',
				fromLabel: 'De',
				toLabel: 'À',
				customRangeLabel: 'Personnalisé',
				firstDay: 1
			}
		}, function(start, end) {
			$('#daterange-filter span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
			var gap = end.diff(start, 'days');
			$('#daterange-prev-date').html(moment(start).subtract(gap, 'days').format('D MMMM') + ' - ' + moment(start).subtract(1, 'days').format('D MMMM YYYY'));
		});
	}
};

// 3. Gestion des autres graphiques (Sécurisés)
var handleVisitorsAreaChart = function() {
	if ($('#visitors-line-chart').length !== 0) {
		// Logique NVD3 ici (si utilisée)
	}
};

var handleVisitorsMap = function() {
	if ($('#visitors-map').length !== 0) {
		// Logique JVectorMap ici
	}
};

// INITIALISATION GLOBALE
var DashboardV3 = function () {
	"use strict";
	return {
		init: function () {
			handleTotalSalesSparkline();
			handleDateRangeFilter();
			handleVisitorsAreaChart();
			handleVisitorsMap();
			// Note : J'ai désactivé les sparklines de conversion si tu ne les utilises pas
		}
	};
}();

$(document).ready(function() {
	DashboardV3.init();
});