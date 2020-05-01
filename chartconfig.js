var tempconfig = {
  type:"area",
  scales: {
    "bottom" : {
      text: "hour"
    },
    "left" : {
      maxTicks: 12,
      max: 120,
      min: 0
    }
  },
  series: [
    {
      id: "A",
      value: "temp",
      color: "#5E83BA",
      strokeWidth: 2
    },
    {
      id: "B",
      value: "humidity",
      color: "#81C4E8",
      strokeWidth: 3
    },
    {
      id: "C",
      value: "fanstate",
      color: "#74A2E7",
      strokeWidth: 4
    }
  ],
  legend: {
    series: ["A", "B", "C"],
    halign: "right",
    valign: "top"
  }
};

var hconfig = {
  type:"area",
  scales: {
    "bottom" : {
      text: "month"
    },  
    "left" : {
      maxTicks: 10,
      max: 100,
      min: 0
    }   
  },
  series: [
    {   
      id: "A",
      value: "company C",
      color: "#5E83BA",
      strokeWidth: 2
    }
  ]     
};

