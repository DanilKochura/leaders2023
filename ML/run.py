import pandas as pd
import numpy as np
from catboost import CatBoostRegressor


def main(leg_orig, leg_dest, dep_time1, arr_time1, equip1, month, weekday, classes):
    # data, output_path = sys.argv[1:]
    df =['flt_num', 'sorg', 'sdst', 'sscl1', 'seg_class_code', 'pass_bk', 'dtd',
       'tt_dep', 'tt_arr', 'equip', 'weekday', 'month', 'year']
    model = CatBoostRegressor()
    model.load_model('model.json')
    return model.predict(data=df)

if name == "main":
    main()