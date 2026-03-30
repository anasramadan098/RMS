# filepath: c:\xampp\htdocs\host\RMS_2\pricing_analysis.py
import pandas as pd
from sklearn.linear_model import LinearRegression
import json
import sys


# قراءة البيانات من JSON (مثال: أسعار الوجبات)
data = json.loads(sys.argv[1])  # تمرير JSON من Laravel
df = pd.DataFrame(data['products'])

# تحليل بسيط: تنبؤ سعر بناءً على التكلفة
X = df[['cost']]  # افترض حقل cost
y = df['price']
print(json.dump({"str": "anas" }))

# model = LinearRegression().fit(X, y)
# predictions = model.predict(X)

# # إخراج النتائج كـJSON
# output = {'predictions': predictions.tolist()}
# print(json.dumps(output))