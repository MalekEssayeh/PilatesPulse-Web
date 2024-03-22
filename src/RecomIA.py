import matplotlib.pyplot as plt
import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
import sys

sexe = sys.argv[1]
age = int(sys.argv[2])
height = int(sys.argv[3])
weight = int(sys.argv[4])
data = {    "sexe":  ["Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme","Femme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme",  "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme", "Homme", "Femme"],
            "age":   [42, 31, 58, 24, 20, 62, 18, 40, 48, 29, 65, 23, 19, 60, 17, 38, 44, 26, 61, 22, 18, 58, 16, 36, 40, 28, 56, 20, 17, 54, 15, 32, 36, 24, 52, 18, 14, 50, 12, 28, 32, 20, 48, 16, 13, 56, 35, 63, 27, 23, 68, 20, 45, 52, 33, 60, 25, 21, 66, 18, 42, 48, 30, 57, 22, 19, 64, 16, 40, 44, 28, 54, 20, 17, 62, 14, 36, 40, 24, 50, 18],
            "height":[178, 165, 180, 170, 185, 158, 182, 175, 168, 162, 176, 160, 188, 155, 180, 173, 169, 160, 184, 162, 176, 155, 180, 173, 169, 160, 182, 170, 185, 158, 180, 173, 169, 160, 184, 162, 176, 155, 180, 173, 169, 160, 182, 170, 185, 165, 180, 172, 168, 183, 155, 180, 173, 169, 160, 184, 162, 176, 155, 180, 173, 169, 160, 182, 170, 185, 158, 180, 173, 169, 160, 184, 162, 176, 155, 180, 173, 169, 160, 182, 170],
            "weight":[75, 55, 80, 60, 78, 48, 72, 68, 70, 52, 85, 50, 82, 45, 70, 65, 73, 50, 83, 52, 68, 47, 75, 60, 72, 50, 80, 60, 78, 48, 72, 65, 70, 50, 85, 52, 68, 45, 70, 65, 72, 50,50, 80, 60, 78, 58, 82, 65, 60, 75, 45, 70, 62, 73, 50, 80, 58, 68, 48, 72, 65, 70, 50, 85, 62, 75, 45, 70, 68, 73, 50, 83, 58, 68, 47, 72, 60, 70, 50, 80],
            "muscle":["Abdominaux", "PlancherPelvien", "Dos", "Fessiers","Abdominaux", "PlancherPelvien","Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule", "Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules"]
                                                                            }
df = pd.DataFrame(data)
muscle_mapping = {"Abdominaux": 1, "PlancherPelvien": 2, "Dos": 3, "Fessiers": 4, "Cuisses": 5, "Epaules": 6, "Bras": 7, "StabilisateurEpaule": 8}
df["muscle_encoded"] = df["muscle"].map(muscle_mapping)
sexe_mapping = {"Femme": 1, "Homme": 0}
df["sexe_encoded"] = df["sexe"].map(sexe_mapping)
X = df[["sexe_encoded", "age", "height", "weight"]]
y = df["muscle_encoded"]
model = LinearRegression()
model.fit(X, y)
sexe_encoded = sexe_mapping.get(sexe, -1)
if sexe_encoded == -1:
        print(f"Unknown sexe: {sexe}")
new_data = pd.DataFrame({
        "sexe_encoded": [sexe_encoded],
        "age": [age],
        "height": [height],
        "weight": [weight]
    })
predicted_muscle = model.predict(new_data)[0]
muscle_names = ["Abdominaux", "PlancherPelvien", "Dos", "Fessiers", "Cuisses", "Epaules", "Bras", "StabilisateurEpaule"]
print( muscle_names[int(predicted_muscle) - 1])
