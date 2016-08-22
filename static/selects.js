//Javascript adapted from:
//Matt Kruse <matt@mattkruse.com>
//http://www.mattkruse.com/
function sortSelect(obj)
{ 
  var o = new Array();
  for(var i=0; i<obj.options.length; i++)
    o[o.length] = new Option( obj.options[i].text, obj.options[i].value, obj.options[i].defaultSelected, obj.options[i].selected);
  o = o.sort(function(a,b)
            {
              if((a.text+"")<(b.text+""))
                return -1;
              if((a.text+"")>(b.text+""))
                return 1;
              return 0;
            });
  for(var i=0; i<o.length; i++)
    obj.options[i] = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
}

function moveSelectedOptions(from,to)
{
  for (var i=0; i<from.options.length; i++)
  {
    var o = from.options[i];
    if (o.selected)
    {
      var index=to.options.length;
      to.options[index] = new Option( o.text, o.value, false, false);
    }
  }

  for (var i=(from.options.length-1);i>=0;i--)
  {
    var o = from.options[i];
    if(o.selected)
      from.options[i] = null;
  }

  from.selectedIndex=-1;
  to.selectedIndex=-1;
  sortSelect(to);
}

function selectSum(obj)
{
  var sum = 0;
  for (var i=0; i<obj.options.length; i++)
    sum+=parseInt(obj.options[i].value);
  return sum;
}

function updateFilterValues(callback_fn) {
  callback_fn(
    selectSum(document.getElementsByName('c_es')[0]),
    selectSum(document.getElementsByName('c_ds')[0]),
    selectSum(document.getElementsByName('c_is')[0])
  );
}

