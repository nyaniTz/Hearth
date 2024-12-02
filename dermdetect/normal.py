import cv2
import joblib
import numpy as np

# import tensorflow as tf
# from flask import Flask, request, render_template
# from tensorflow import keras
# from keras.layers import Dense
# from keras.models import Sequential, load_model

from flask import Flask, request, jsonify
from flask_cors import CORS

application = Flask(__name__)
CORS(application)

UPLOAD_FOLDER = './uploads'
DEVICE="cuda"
MODEL=None

def preprocess_image(image_path):
    #  image preprocessing logic 
    #  resizing the image to match model's input size
    img = Image.open('./uploads/' + image_path)
    img = img.resize((28, 28))  # Adjusting image size according to model's requirements
    img_array = np.array(img) / 255.0  # Normalizing pixel values between 0 and 1
    return img_array.reshape(1, 28, 28, 3)  # Assuming a 3-channel image

def predict_class(image_location):
    # Loading the trained model
    # Load your model
    svm_model = joblib.load(open("./model/teyeis_svm_model.pkl","rb"))

    img = cv2.imread('./uploads/' + image_location)

    # Resize the image to (28, 28)
    img_resized = cv2.resize(img, (28, 28))

    img_reshaped = img_resized.reshape((1, 2352))

    # Now, you can use img_reshaped for prediction
    pred = svm_model.predict(img_reshaped)

    print(pred)

    return pred[0]


@application.route("/predict/", methods=['GET'])
def predict():
    image_location = request.args.get("image")
    predicted_class = predict_class(image_location)

    results = {
        "prediction": int(predicted_class)
    }

    response = jsonify(results)
    response.headers.add('Access-Control-Allow-Origin', '*')
    return response

if __name__ == "__main__":
   application.run()

