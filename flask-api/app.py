from flask import Flask, request, jsonify
from flask_cors import CORS
import joblib
import numpy as np

app = Flask(__name__)
CORS(app)  # Enable CORS for local testing

# Load trained model
model = joblib.load('linear_model.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    features = data['features']
    
    # Ensure all features are numeric
    features = [float(x) for x in features]
    features_array = np.array(features).reshape(1, -1)
    
    prediction = model.predict(features_array)
    return jsonify({'prediction': prediction.tolist()})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
