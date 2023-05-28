
import sys
import pandas as pd
import numpy as np
from catboost import CatBoostRegressor


def main(leg_orig, leg_dest, dep_time1, arr_time1, equip1, month, weekday, classes):
    print('work')
    # data, output_path = sys.argv[1:]
    df =[leg_orig, leg_dest, classes, dep_time1, arr_time1, equip1, weekday, month]
    model = CatBoostRegressor()
    model.load_model('model_pass_dep.json')
    return model.predict(data=df)

if __name__ == "__main__":
    main(sys.argv[1],sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5],sys.argv[6],sys.argv[7],sys.argv[8])