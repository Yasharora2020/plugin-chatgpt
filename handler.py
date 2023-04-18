import boto3
import os
import openai
import json

# Define the prompt for the OpenAI API
prompt = "Please answer the following question about Australian Tax:"

def chatGpt1(event, context):
    # Retrieve the input text and follow-up counter from the event
    input_text = event['input_text']
    follow_up_count = event.get('follow_up_count', 0)
    
    # Check if the input text contains any of the keywords
    keywords = ["tax","taxes" "superannuation", "employment taxes"]
    if not any(keyword in input_text.lower() for keyword in keywords):
        return {
            "statusCode": 400,
            "body": "Please ask a question related to Australian tax, superannuation, or employment taxes."
        }
    
    # Check if the follow-up count has reached the limit
    if follow_up_count >= 5:
        return {
            "statusCode": 400,
            "body": "You have reached the maximum number of follow-up questions."
        }
    
    # Retrieve the OpenAI API key from Secrets Manager
    secret_name = "dev/openai/api"
    region_name = "ap-southeast-2"
    session = boto3.session.Session()
    client = session.client(service_name='secretsmanager', region_name=region_name)
    
   
   
    # Initialize the OpenAI API key
    get_secret_value_response = client.get_secret_value(SecretId=secret_name)
    api_key = get_secret_value_response['SecretString']
    secret_dict = json.loads(api_key)
    openai_api_key = secret_dict['OPENAI_API']
    openai.api_key = openai_api_key.strip()
   
    
    
    # Create the prompt for the OpenAI API
    full_prompt = f"{prompt} {input_text}. Limit your response to 500 words."
    
    # Set the OpenAI API parameters
    model = "text-davinci-003"
    temperature = 0.5
    max_tokens = 200
    
    # Send the request to the OpenAI API
    response = openai.Completion.create(
        engine=model,
        prompt=full_prompt,
        temperature=temperature,
        max_tokens=max_tokens
    )
    
    # Extract the answer from the OpenAI API response and count the number of words
    answer = response.choices[0].text.strip()
    word_count = len(answer.split())
    
    # Check if the word count exceeds the limit
    if word_count > 200:
        return {
            "statusCode": 400,
            "body": "I'm sorry, I cannot answer this question in 500 words or less."
        }
    
    # Increment the follow-up count
    follow_up_count += 1
    
    # Return the answer and updated follow-up count as a JSON object
    return {
        "statusCode": 200,
        "body": answer,
        "follow_up_count": follow_up_count
    }
