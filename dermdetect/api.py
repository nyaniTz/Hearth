import os
import numpy as np
from PIL import Image
import tensorflow as tf
from flask import Flask, request, render_template
from tensorflow import keras
from keras.layers import Dense
from keras.models import Sequential, load_model
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
    model = load_model('./model/CNN_Model2.h5') 

    # if(image_location == )

    # Preprocess the image
    preprocessed_image = preprocess_image(image_location)

    # Make a prediction
    predictions = model.predict(preprocessed_image)

    # Get the predicted class (assuming it's the class with the highest probability)
    predicted_class = np.argmax(predictions, axis=1)[0]

    return predicted_class

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
