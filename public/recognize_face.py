import sys
import face_recognition

# Check arguments
if len(sys.argv) != 3:
    print("Usage: python recognize_face.py known.jpg unknown.jpg")
    sys.exit(1)

known_path = sys.argv[1]
unknown_path = sys.argv[2]

# Load known image
known_image = face_recognition.load_image_file(known_path)
known_encodings = face_recognition.face_encodings(known_image)

if not known_encodings:
    print("No se encontró ningún rostro en la imagen conocida.")
    sys.exit(1)

known_encoding = known_encodings[0]

# Load unknown image
unknown_image = face_recognition.load_image_file(unknown_path)
unknown_encodings = face_recognition.face_encodings(unknown_image)

if not unknown_encodings:
    print("No se encontró ningún rostro en la imagen capturada.")
    sys.exit(1)

unknown_encoding = unknown_encodings[0]

# Compare faces
results = face_recognition.compare_faces([known_encoding], unknown_encoding)

if results[0]:
    print("Cara reconocida!")
else:
    print("Cara desconocida.")
