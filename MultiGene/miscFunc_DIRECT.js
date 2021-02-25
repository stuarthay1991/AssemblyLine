function add(a, b) {
    return a + b;
}

function serverSecretSet()
{
	document.getElementById("SERVER_SECRET").value = document.getElementById("DATABASE_CONNECT").value;
	document.getElementById("view5_default").style.display = "none";
	document.getElementById("view5_loading").style.display = "block";
}

function func1()
{
		console.log("1 click");
		VARIABLE_PDF_FILE_ID = '#baseBiggie';
}

function func2()
{
		console.log("2 click");
		VARIABLE_PDF_FILE_ID = '#baseBiggie2';
}

function downloadTable()
{
	var download_bubble = new DownloadBubble("TABLE");
	if(document.getElementById("check_boxd_t1").checked == true)
	{
		download_bubble.putIn(norm_view_all_expression, c, norm_view_all_titles, "Norm-View");
	}
	download_bubble.download();
}

function statisticsFunction()
{
	console.log("YEAH");
	console.log(document.getElementById("combo1").value);
	console.log(document.getElementById("combo2").value);
	array_for_group = [];
	X_group = [];
	for(var i = 0; i < ch_c.length; i++)
	{
		if(document.getElementById("combo2").value == ch_group_dict[i]["group_num"])
		{
			if(document.getElementById("combo1").value == 1)
			{
				array_for_group.push(parseFloat(ch_y1[ch_c[i]]));
			}
			if(document.getElementById("combo1").value == 2)
			{
				array_for_group.push(parseFloat(ch_y2[ch_c[i]]));
			}
			if(document.getElementById("combo1").value == 3)
			{
				array_for_group.push(parseFloat(ch_y3[ch_c[i]]));
			}
			if(document.getElementById("combo1").value == 4)
			{
				array_for_group.push(parseFloat(ch_y4[ch_c[i]]));
			}
			if(document.getElementById("combo1").value == 5)
			{
				array_for_group.push(parseFloat(ch_y5[ch_c[i]]));
			}
		}
	}

	for(var i = 0; i < X_c.length; i++)
	{
		if(document.getElementById("combo2").value == X_group_dict[i]["group_num"])
		{
			if(document.getElementById("combo1").value == 1)
			{
				X_group.push(parseFloat(X_y1[X_c[i]]));
			}
			if(document.getElementById("combo1").value == 2)
			{
				X_group.push(parseFloat(X_y2[X_c[i]]));
			}
			if(document.getElementById("combo1").value == 3)
			{
				X_group.push(parseFloat(X_y3[X_c[i]]));
			}
			if(document.getElementById("combo1").value == 4)
			{
				X_group.push(parseFloat(X_y4[X_c[i]]));
			}
			if(document.getElementById("combo1").value == 5)
			{
				X_group.push(parseFloat(X_y5[X_c[i]]));
			}
		}
	}
	
	ch_w = array_for_group.length;
	ch_x = X_group.length;
	sum_w = array_for_group.reduce(add, 0);
	sum_x = X_group.reduce(add, 0);
	avg_w = sum_w / ch_w;
	avg_x = sum_x / ch_x;
	
	var data = [
	  {
		x: ['Wild Type', 'Mutants'],
		y: [avg_w, avg_x],
		type: 'bar'
	  }
	];


	Plotly.newPlot("statistics_panel1", data);
}

function searchForCell()
{
	var input_val = document.getElementById("cell_search_input").value;
	for(var i = 0; i < fatSVG.length; i++)
	{
		curSVG = fatSVG[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
    			if(this.attributes.cell.value.toLowerCase() == input_val.toLowerCase())
				{
					var found_thing = d3.select(this);
					repeat(found_thing, this.attributes.off_color.value, curSVG);
				}
				else
				{
					var useless_thing = d3.select(this);
					greyRepeat1(useless_thing, this.attributes.off_color.value, curSVG);
				}					
    		}
		});

	}
}

function OldsearchForCell()
{
	var input_val = document.getElementById("old_cell_search_input").value;
	for(var i = 0; i < UNI_SVG_LIST.length; i++)
	{
		curSVG = UNI_SVG_LIST[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
    			if(this.attributes.cell.value.toLowerCase() == input_val.toLowerCase())
				{
					var found_thing = d3.select(this);
					repeat(found_thing, this.attributes.off_color.value, curSVG);
				}
				else
				{
					var useless_thing = d3.select(this);
					greyRepeat1(useless_thing, this.attributes.off_color.value, curSVG);
				}					
    		}
		});

	}
}


function repeat(f_t, color, cursvg)
{
	var hig = cursvg.tip;

	f_t
		.style("fill", "yellow")
		.style("stroke", "red")
		.style("opacity", 1)
		.style("stroke-width", 2);

	f_t	
		.on("mouseover", function(){
				d3.select(this).style("fill", "red");
				d3.select(this).style("stroke", "blue");				
				hig.show(this.attributes);
		})
		.on("mouseout", function(){
				d3.select(this).style("fill", "yellow");
				d3.select(this).style("stroke", "red");
				hig.hide();
		})

		
}

function greyRepeat1(u_t, color, cursvg)
{
	var hig = cursvg.tip;

	u_t
		.style("fill", "grey")
		.style("stroke", "grey")
		.style("opacity", 0.5);

	u_t
		.on("mouseover", function(){
				hig.show(this.attributes);
		})
		.on("mouseout", function(){
				hig.hide();
		})
		
}


function basicGrayOut(u_t, cursvg)
{
	var hig = cursvg.tip;
	console.log("FRAGOO2");

	u_t
		.style("fill", "grey")
		.style("stroke", "grey")
		.style("opacity", 0.9)
		.style("stroke-width", 1);

	u_t
		.on("mouseover", function(){
				hig.show(this.attributes);
		})
		.on("mouseout", function(){
				hig.hide();
		})
}

function restoreColor(f_t, color, cursvg)
{
	var hig = cursvg.tip;

	f_t
		.transition()
		.style("fill", color)
		.style("stroke", color)
		.style("opacity", 1)
		.style("stroke-width", 1)		
		.delay(500)
		.duration(1000);							

	f_t
		.on("mouseover", function(){
			d3.select(this).style("fill", "white");
			d3.select(this).style("stroke", "red");
			hig.show(this.attributes);
		})
		.on("mouseout", function(){
			d3.select(this).style("fill", this.attributes.off_color.value);
			d3.select(this).style("stroke", this.attributes.off_color.value);
			hig.hide();
		})


}

function highlightColor(f_t, cursvg, color)
{
	var hig = cursvg.tip;
	
	f_t
		.style("fill", color)
		.style("stroke", color)
		.style("opacity", 1)
		.style("stroke-width", 1);

	f_t
		.on("mouseover", function(){
			d3.select(this).style("fill", "white");
			d3.select(this).style("stroke", "red");
			hig.show(this.attributes);
		})
		.on("mouseout", function(){
			d3.select(this).style("fill", this.attributes.off_color.value);
			d3.select(this).style("stroke", this.attributes.off_color.value);
			hig.hide();
		})

}

function highlightMatches(set, SVG_GROUP)
{
	for(var i = 0; i < SVG_GROUP.length; i++)
	{
		console.log("SVG iteration");
		curSVG = SVG_GROUP[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
    			if(set.has(this.attributes.cell.value))
				{
					var found_thing = d3.select(this);
					highlightColor(found_thing, curSVG, this.attributes.off_color.value);
				}
				else
				{
					var useless_thing = d3.select(this);
					basicGrayOut(useless_thing, curSVG);
				}					
    		}
		});
		
	}
}

function restoreGroupColor(SVG_GROUP)
{
	for(var i = 0; i < SVG_GROUP.length; i++)
	{
		curSVG = SVG_GROUP[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
				var found_thing = d3.select(this);
				restoreColor(found_thing, this.attributes.off_color.value, curSVG);
    		}
		});
		
	}	
}

function restoreAll()
{
	restoreGroupColor(MUT_SVG_LIST);
	restoreGroupColor(WILD_SVG_LIST);
	restoreGroupColor(fatSVG);
}

function OldrestoreAll()
{
	restoreGroupColor(UNI_SVG_LIST);
}

function OldcaptureCells()
{
	var input_val = document.getElementById("old_capture_combo").value;
	var capture_set;
	var group;
	for(var i = 0; i < js_ticks_all_table.length; i++)
	{
		if(js_ticks_all_table[i]["GroupName"] == input_val)
		{
			group = i;
			console.log("Tick_group", group);
		}
	}
	capture_set = OldlogColsCapture(js_ticks_all_table[group]);
	highlightMatches(capture_set, UNI_SVG_LIST);

}

function OldlogColsCapture(tick_series)
{
	var set1 = new Set();
	for(var i = 0; i < c.length; i++)
	{
		var editedcell = c[i].replace(/\n/ig, '');
		if(tick_series[editedcell] == "1")
		{
			set1.add(editedcell);
		}
	}
	return set1;

}

function combineSVGs_normview(SVGs_Array, headerSVG, tickSVG)
{
	bigSVG = d3.select("#save_SVG_stash")
		.append("svg")
		.attr("id", "baseBiggie")
		.attr("width", 1220)
		.attr("height", 700);    
	
	bigSVG.append("rect")
		.attr("width", "100%")
		.attr("height", "100%")
		.style("stroke", "White")
		.attr("type", "canvas")
		.attr("fill", "White");

	var Y_begin = 150;
	var y_axis_begin = 76;
	var stringY;
	var big_bag_of_svg_objects;
	//var y_tick_start = (SVGs_Array.length * 70) + 150 + 40;
	var y_tick_start = 450;
	
	bigSVG.append("text")
		.attr("x", 300)             
		.attr("y", 35)
		.attr("text-anchor", "middle")  
		.style("font-size", "24px") 
		.style('fill', 'black')
		.text("Norm-View All Genes");
	
	//BUILD HEADER
	headSVG = headerSVG.SVG;
	big_bag_of_svg_objects = headSVG.selectAll("*");
	big_bag_of_svg_objects.each(function(d) { 	
    	if(this.attributes.type.value == "group_id")
    	{
			var color = this.attributes.fill_color.value;
			var x_position = (this.x.animVal.value / 2.1) + 22;
			var y_position = 40;
			var height = 9;
			var width = this.width.animVal.value / 2.1;

			bigSVG.append("rect")
				.style("stroke", color)
				.style("fill", color)
				.attr("x", x_position)
				.attr("y", 70)
				.attr("width", width)
				.attr("height", 9);	
		}
		if(this.attributes.type.value == "description")
		{
			var x_position = this.x.animVal[0].value;
			var y_position = 65;
			var text_anchor = "middle";
			var font_color = "black";
			var font_size = "4px";
			var text_value = this.textContent;

			bigSVG.append("text")
				.attr("x", x_position/2.1 + 22)             
				.attr("y", y_position)
				.attr("text-anchor", text_anchor)  
				.style("font-size", font_size) 
				.style('fill', 'black')
				.text(text_value);
		}
	});

	//BUILD TEXTS
	tick_SVG = tickSVG.SVG;
	big_bag_of_svg_objects = tick_SVG.selectAll("*");
	big_bag_of_svg_objects.each(function(d) { 
		if(this.attributes.type.value == "tick")
		{
			var x_position = (this.x.animVal.value / 2.1) + 22;
			var y_position = y_tick_start + this.y.animVal.value;
			var width = (this.width.animVal.value / 2.1);
			var color = this.attributes.off_color.value;
			
			bigSVG.append("rect")
				.style("stroke", color)
				.style("fill", color)
				.attr("x", x_position)
				.attr("y", y_position)
				.attr("width", width)
				.attr("height", 20);	
			
		}

		if(this.attributes.type.value == "description")
		{
			var x_position = 20;
			var y_position = y_tick_start + this.y.animVal[0].value + 2;
			var color = "black";

	
			bigSVG.append("text")
				.attr("x", 20)             
				.attr("y", y_position)
				.attr("text-anchor", "middle") 
				.style("font-size", this.attributes.stored_size.value) 
				.style('fill', 'black')
				.text(this.textContent);
		}

	});
	
	for(var i = 0; i < SVGs_Array.length; i++)
	{


		stringY = Y_begin.toString();
		Bob_Extreme = 'Grumpy_Bob'.concat(i.toString());
		curSVG = SVGs_Array[i].SVG;	
		big_bag_of_svg_objects = curSVG.selectAll("*");		
		big_bag_of_svg_objects.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
				var width = this.width.animVal.value / 2.1;
				var height = (this.attributes.expression.value * 3);
				var x_position = (this.x.animVal.value / 2.1) + 22;
				var y_position = Y_begin - (this.attributes.expression.value * 3);
				var color = this.attributes.off_color.value;
				var border_color = this.attributes.off_color.value;
				
				bigSVG.append("rect")
					.style("stroke", color)
					.style("fill", color)
					.attr("x", x_position)
					.attr("y", y_position)
					.attr("width", width)
					.attr("height", height);
			}
    		if(this.attributes.type.value == "title")
    		{
				var x_position = (this.x.animVal[0].value - y_axis_begin);
				var y_position = this.y.animVal[0].value + 6;
				var font_color = "black";
				var font_size = "12px";
				var text_anchor = "start";
				var transform = 'rotate(-90 45 55)';
				var text_value = this.textContent;

				bigSVG.append("text")
					.attr("x", x_position)             
					.attr("y", y_position)
					.attr("text-anchor", text_anchor)  
					.style("font-size", font_size) 
					.style('fill', font_color)
					.text(text_value)
					.attr('transform', 'rotate(-90 45 55)');

			}
    		if(this.attributes.type.value == "axis")
    		{
				var x1= this.x1.animVal.value;
				var x2 = this.x2.animVal.value;
				var y1 = this.y1.animVal.value;
				var y2 = this.y2.animVal.value;
				var thickness = 1;
				var color = "black";

				bigSVG.append("line")
					.attr("x1", x1)
					.attr("y1", (y1 + y_axis_begin))
					.attr("x2", x2)
					.attr("y2", (y2 + y_axis_begin))
					.attr("stroke-width", thickness)
					.attr("stroke", color);

			}
    		if(this.attributes.type.value == "y_axis_label")
    		{	
				var x_position = this.x.animVal[0].value;
				var y_position = this.y.animVal[0].value + y_axis_begin;
				var text_anchor = "middle";
				var font_color = "black";
				var font_size = "8px";
				var text_value = this.textContent;

				bigSVG.append("text")
					.attr("x", x_position)             
					.attr("y", y_position)
					.attr("text-anchor", text_anchor)  
					.style("font-size", font_size) 
					.style('fill', font_color)
					.text(text_value);
				
			}
		});
		Y_begin = Y_begin + 70;
		y_axis_begin = y_axis_begin + 70;
		
	//		d3.select("#baseBiggie")
//			.append("use")
//			.attr("xlink:href", "#" + Bob_Extreme)
//			.attr("transform", "translate(30,".concat(stringY).concat(")"));
		
//		Y_begin = Y_begin + 100
		
	}
	
	
}

function groupSplitSet(colset, groupset, group_name)
{
	
	var out_col = [];
	var out_group = [];
	for(var h = 0; h < group_name.length; h++)
	{
		var cur_name = group_name[h];
		for(var i = 0; i < colset.length; i++)
		{
			cur_group = groupset[i];
			cur_col = colset[i];
			cur_group_name = cur_group["group_name"];
			if(cur_group_name == cur_name)
			{
				out_group.push(cur_group);
				out_col.push(cur_col);
			}
		}
	}
	var return_obj = [out_col, out_group];
	return return_obj;
}

function goodCombine(SVGs_Array, headerSVG, tickSVG)
{
	bigSVG = d3.select("#d_png")
		.append("svg")
		.attr("id", "download_svg")
		.attr("width", 1220)
		.attr("height", 700);    
	
	bigSVG.append("rect")
		.attr("width", "100%")
		.attr("height", "100%")
		.style("stroke", "White")
		.attr("type", "canvas")
		.attr("fill", "White");
	
}

function resampleGroups(sample_int_set, target_set)
{
	var new_sample_array = [];
	for(var i = 0; i < sample_int_set.length; i++)
	{
		new_sample_array.push(target_set[sample_int_set[i]]);
	}
	return new_sample_array;
}
