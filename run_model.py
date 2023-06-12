
import sys
import pandas as pd
import numpy as np
from catboost import CatBoostRegressor
import json


def main(sorg, sdst, sscl1, tt_dep, tt_arr, equip, weekday, month):
    lis = np.array([])
    model = CatBoostRegressor()
    model.load_model('model.cbm')

    for dtd in range(217, 1, -1):
        df =[sorg, sdst, sscl1, dtd, tt_dep, tt_arr, equip, weekday, month]
        lis = np.append(lis, model.predict(data=df))

    lis = list(lis)
    print(json.dumps(lis))
if __name__ == "__main__":
    main(sys.argv[1],sys.argv[2], sys.argv[3], sys.argv[4],sys.argv[5],sys.argv[6],sys.argv[7],sys.argv[8])