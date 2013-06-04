// This method is horribly inefficient.
function formatCost (cost) {
  var ret, ix, jx, str, isPositive;
  
  isPositive = cost >= 0;
  str = isPositive ? String(cost) : String(cost).slice(1);
  
  ret = "";
  for (ix = str.length - 1, jx = 0; ix >= 0; ix--, jx++) {
    ret += str[ix];
    if (jx % 3 === 2) ret += ",";
  }
  
  ret = ret.split("").reverse();
  if (ret[0] === ",") ret.shift();
  return (isPositive ? "$" : "-$") + ret.join("");
}

function moneyToNumber (money) {
  return Number(money.replace(/[$,]/g, ""));
};