parseSpectra = function (txt) {

	var lines = txt.split('\n');
	var lineAmount = lines.length;		
	var firstCol = [],
	 secondCol = [],
	 thirdCol = [],
	 tempData = [];	//temp array used to create 2d array

	for(var i = 0; i < lineAmount; i++){
		//Lines are parsed into columns by specific formatting of my data
		//Probably a more robust, more general way of doing this
		firstCol[i] = parseFloat(lines[i].split(",")[0]);
		secondCol[i] = parseFloat(lines[i].split(",")[2]);
		thirdCol[i] = parseFloat(lines[i].split(",")[1]);
	}
	

	var JSONstr = "[";
	for (var i=0;i<lineAmount-2;i++) {
		if (i>0) {
		JSONstr += ",";
		}
		JSONstr += '\n';
		JSONstr += "{";
		JSONstr += '"x":';
		JSONstr += firstCol[i];
		JSONstr += ',"y1":';
		JSONstr += secondCol[i];
		JSONstr += ',"y2":';
		JSONstr += thirdCol[i];
		JSONstr += "}";
	}
	JSONstr += "]";
	
	//console.log(JSONstr);
	//d3Plot(graphData);	//send final 2d array to be plotted
	d3Plot_JSON(JSONstr);

	}   


d3Plot_JSON = function(JSONstr){ 

	margin = {
		top: 20,
		right: 20,
		bottom: 20,
		left: 45
	};

	data = JSON.parse(JSONstr);
	
	//Width and height
	width = 960 - margin.left - margin.right;
	height = 500 - margin.top - margin.bottom;

	//Scale data to fit window
	var x = d3.scale.linear()
		.domain(d3.extent(data, function (d) {
		return d.x;
	}))
		.range([0, width]);

	var y1 = d3.scale.linear()
		.domain(d3.extent(data, function (d) {
		return d.y1;
	}))
		.range([height, 0]);
		
	var y2 = d3.scale.linear()
		.domain(d3.extent(data, function (d) {
		return d.y2;
	}))
		.range([height, 0]);

	//Describe line
	var line1 = d3.svg.line()
		.x(function (d) {
		return x(d.x);
	})
		.y(function (d) {
		return y1(d.y1);
	});
	
	var line2 = d3.svg.line()
		.x(function (d) {
		return x(d.x);
	})
		.y(function (d) {
		return y2(d.y2);
	});

	//Zoom!
	var zoom = d3.behavior.zoom()
		.x(x)
		.y(y1)
		.scaleExtent([0.9,10])
		.on("zoom", zoomed);

	//Init svg object
	svg = d3.select('#chart')
		.append("svg:svg")
		.attr('width', width + margin.left + margin.right)
		.attr('height', height + margin.top + margin.bottom)
		.call(zoom)
		.append("svg:g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	//Functions for scaling axes
	var make_x_axis = function () {
		return d3.svg.axis()
			.scale(x)
			.orient("bottom")
			.ticks(16);
	};

	var make_y_axis_left = function () {
		return d3.svg.axis()
			.scale(y1)
			.orient("left")
			.ticks(16);
	};
	
	var make_y_axis_right = function () {
		return d3.svg.axis()
			.scale(y1)
			.orient("right")
			.ticks(16);
	};

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")
		.ticks(8);

	svg.append("svg:g")
		.attr("class", "x axis")
		.attr("transform", "translate(0, " + height + ")")
		.call(xAxis);

	var yAxisLeft = d3.svg.axis()
		.scale(y1)
		.orient("left")
		.ticks(5);
		
	var yAxisRight = d3.svg.axis()
		.scale(y1)
		.orient("right")
		.ticks(5);
		
	//Put axes on chart

	svg.append("g")
		.attr("class", "y1 axis")
		.style("fill", "blue")
		.call(yAxisLeft);
	
	svg.append("g")             
		.attr("class", "y1 axis")    
		.attr("transform", "translate(" + width + " ,0)")   
		.style("fill", "red")       
		.call(yAxisRight);

	svg.append("g")
		.attr("class", "x grid")
		.attr("transform", "translate(0," + height + ")")
		.call(make_x_axis()
		.tickSize(-height, 0, 0)
		.tickFormat(""));

	svg.append("g")
		.attr("class", "y1 grid")
		.call(make_y_axis_left()
		.tickSize(-width, 0, 0)
		.tickFormat(""));
		
	svg.append("g")
		.attr("class", "y1 grid")
		.call(make_y_axis_right()
		.tickSize(-width, 0, 0)
		.tickFormat(""));
		
	
	//Render stuff when zoomed in

	var clip = svg.append("svg:clipPath")
		.attr("id", "clip")
		.append("svg:rect")
		.attr("x", 0)
		.attr("y1", 0)
		.attr("width", width)
		.attr("height", height);

	var chartBody = svg.append("g")
		.attr("clip-path", "url(#clip)");

	chartBody.append("svg:path")
		.datum(data)
		.attr("class", "line")
		.attr("d", line1)
		
//	line2.style("fill", "red")
	
	chartBody.append("svg:path")
		.datum(data)
		.attr("class", "line")
		.attr("d", line2);

	//Function for how to behave when zooming in
	function zoomed() {
		svg.select(".x.axis").call(xAxis);
		svg.select(".y1.axis").call(yAxisLeft);
		svg.select(".x.grid")
			.call(make_x_axis()
			.tickSize(-height, 0, 0)
			.tickFormat(""));
		svg.select(".y1.grid")
			.call(make_y_axis_left()
			.tickSize(-width, 0, 0)
			.tickFormat(""));
		svg.select(".line1")
			.attr("class", "line1")
			.attr("d", line);
	}
}
