//Driver

class pageDriver {
  constructor(Norm_test, Norm_group, Norm_ticks, n_c) 
  {
	  this.raw_n_test = Norm_test;
	  this.raw_normg = Norm_group;
	  this.raw_n_ticks = Norm_ticks;
	  
	  this.raw_n_c = n_c;
	  
	  this.flag_n_test = "False";
	  this.flag_normg = "False";
	  this.flag_n_ticks = "False";

	  this.allExpArray = [];
	  this.normalized_flag = "True";
	  
	  this.norm_group_set = ""; 
  }
  
  testExpression_norm(test_expression)
  {
	  if(test_expression != "Failed")
	  {
		this.flag_n_test = "True";
	  }
  }

  testGroup_norm(test_group)
  {
	  if(test_group != "Failed")
	  {
		this.flag_normg = "True";
	  }	  
  }
  
  testTicks_norm(test_ticks)
  {
	  if(test_ticks != "Failed")
	  {
		this.flag_n_ticks = "True";
	  }	  
  }
  
  runTests()
  {
	this.testExpression_norm(this.raw_n_test)
	this.testGroup_norm(this.raw_normg)
	this.testTicks_norm(this.raw_n_ticks)
  }

  printTests()
  {
	  console.log("Normal Expression: ", this.flag_n_test);
	  console.log("Normal Groups: ", this.flag_normg);
	  console.log("Normal Ticks: ", this.flag_n_ticks);	  
  }

  buildGroups()
  {
    if(this.flag_normg == "True")
	{
		var norm_g_Set = new Set();
		var norm_g_Dict = {};
		for(var i = 0; i < this.raw_normg.length; i++)
		{
			norm_g_Set.add(this.raw_normg[i]['group_name']);
			norm_g_Dict[this.raw_normg[i]['group_name']] = (parseInt(this.raw_normg[i]['group_num']) - 1).toString();;
		}
		this.norm_group_set = norm_g_Set;
		this.norm_group_dict = norm_g_Dict;
		//console.log(this.norm_group_set);
	}
	else
	{
		var norm_g_Set = new Set();
		norm_g_Set.add("None");
		this.norm_group_set = norm_g_Set;
	}
  }
  
  matchGroupsToNum()
  {
	
  }

  bunchFlags()
  {
	this.allExpArray.push(this.flag_n_test);
  }
  
  checkValues()
  {
	var BAD = 0;
	if(this.raw_n_test != "Failed")
	{
		for(var i = 0; i < this.raw_n_c.length; i++)
		{
			var transi = this.raw_n_c[i];
			transi = transi.replace(/\n/ig, '');
			var cur_val = this.raw_n_test[transi];
			if(parseInt(cur_val) > 20)
			{
				BAD = 1;
				break;
			}
		}
	}
	if(BAD == 0)
	{
		this.normalized_flag = "True";
	}
	else
	{
		this.normalized_flag = "False";
	}
	
  }
  
  normalizeDataset(data_group, columns)
  {
	var cur_data;
	for(var i = 0; i < data_group.length; i++)
	{
		cur_data = data_group[i];
		if(cur_data != "Failed" && cur_data != false)
		{
			for(var k = 0; k < columns.length; k++)
			{
				var cur_col = columns[k];
				cur_col = cur_col.replace(/\n/ig, '');
				var cur_val = cur_data[cur_col];
				cur_val = cur_val + 1;
				cur_val = Math.log2(cur_val);
				cur_data[cur_col] = cur_val;
			}
		}
	}
  }
  
}
