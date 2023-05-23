<div id="app">
  {{ message }}
</div>


<form method="post" id="demand" action="http://localhost/hackathon/api/demand">
    <select name="from" id="">
        <option value="AER">Сочи</option>
        <option value="SVO">Москва</option>
        <option value="3">Астрахань</option>
    </select>
    <select name="to" id="">
        <option value="AER">Сочи</option>
        <option value="SVO">Москва</option>
        <option value="3">Астрахань</option>
    </select>
    <select name="flight" id="">
        <option value="1130">1130</option>
        <option value="1130">1128</option>
    </select>
    <input type="date" id="start" name="date"
    value="2018-07-22">
    <input type="text" name="class" value="E">
    <button type="submit">Submit</button>
</form>

<div>
    <canvas id="myChart"></canvas>
</div>
<script>

</script>