<div class="dashboard">
    <div class="inner-wrapper">
        <form action="http://localhost/hackathon/api/seasons" class="form" id="demand">
            <select name="from" class="from airports">
                <option value="AER" selected>Сочи</option>
                <option value="SVO" >Москва</option>
                <option value="ASF">Астрахань</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon icon-tabler icon-tabler-arrow-narrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l14 0"></path>
                <path d="M15 16l4 -4"></path>
                <path d="M15 8l4 4"></path>
            </svg>
            <select name="to" class="airports">
                <option value="AER" >Сочи</option>
                <option value="SVO" selected >Москва</option>
                <option value=ASF">Астрахань</option>
            </select>
            <select name="flight" style="width: 100px" disabled  id="">

            </select>
            <select name="year" id="">
                <option value="2018">2018</option>
            </select>
            <select name="class" class="class">    <?php foreach($alphabet as $alpha): ?>
                    <option value="<?=$alpha?>"><?=$alpha?></option>    <?php endforeach; ?>
            </select>
            <input type="submit" value="Отправить" class="send-button">
        </form>
        <div class="graph">
            <canvas id="myChart"></canvas>
        </div>
        <div class="scroll">
            <input type="range" min="2" max="365">
            <div class="depth">Глубина: <span id="range" class="range-number"> 10 </span></div>
        </div>
    </div>
</div>


