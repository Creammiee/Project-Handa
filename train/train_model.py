# train_model.py
import pandas as pd
from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error
import numpy as np
import joblib

# Load DATA 2.xlsx
file_path = 'DATA 2.xlsx'
years = ['2009', '2010', '2011', '2012', '2013', '2014', '2015', 
         '2016', '2017', '2018', '2019', '2020', '2021']

data_list = []
for year in years:
    df = pd.read_excel(file_path, sheet_name=year, nrows=1000)
    df['Year'] = int(year)
    data_list.append(df)

data_df = pd.concat(data_list, ignore_index=True)
data_df = data_df.fillna(0)

# Features: all numeric except 'Year' | Target: 'Year' (sample target)
X = data_df.select_dtypes(include=[np.number]).drop('Year', axis=1)
y = data_df['Year']

# Train-Test Split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train Model
model = LinearRegression()
model.fit(X_train, y_train)

# Evaluate
y_pred = model.predict(X_test)
rmse = np.sqrt(mean_squared_error(y_test, y_pred))
print(f"Model RMSE: {rmse}")

# Save model
joblib.dump(model, 'linear_model.pkl')
